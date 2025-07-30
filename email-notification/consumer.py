import pika
import json
import smtplib
from email.mime.text import MIMEText
import os
import sys

sys.stdout.reconfigure(line_buffering=True)

# RabbitMQ connection params from environment variables (with defaults)
RABBITMQ_HOST = os.getenv("RABBITMQ_HOST", "rabbitmq")
RABBITMQ_PORT = int(os.getenv("RABBITMQ_PORT", 5672))
RABBITMQ_USER = os.getenv("RABBITMQ_USER", "guest")
RABBITMQ_PASS = os.getenv("RABBITMQ_PASS", "guest")
RABBITMQ_VHOST = os.getenv("RABBITMQ_VHOST", "/")

# SMTP config (example: Elastic Email)
SMTP_HOST = os.getenv("SMTP_HOST", "smtp.elasticemail.com")
SMTP_PORT = int(os.getenv("SMTP_PORT", 2525))
SMTP_USER = os.getenv("SMTP_USER")
SMTP_PASS = os.getenv("SMTP_PASS")

if not all([SMTP_USER, SMTP_PASS]):
    print("ERROR: SMTP_USER and SMTP_PASS must be set in environment variables!")
    sys.exit(1)

def send_email(to_email, subject, message):
    try:
        msg = MIMEText(message)
        msg['Subject'] = subject
        msg['From'] = SMTP_USER
        msg['To'] = to_email

        with smtplib.SMTP(SMTP_HOST, SMTP_PORT) as server:
            server.starttls()
            server.login(SMTP_USER, SMTP_PASS)
            server.sendmail(SMTP_USER, [to_email], msg.as_string())

        print(f"Email sent to {to_email} with subject: {subject}")
    except Exception as e:
        print(f"Failed to send email: {e}")

def callback(ch, method, properties, body):
    print(f"Received message: {body}")

    try:
        data = json.loads(body)
    except Exception as e:
        print(f"Failed to parse JSON: {e}")
        ch.basic_ack(delivery_tag=method.delivery_tag)
        return

    email = data.get('email')
    subject = data.get('subject')
    message = data.get('message')

    if not (email and subject and message):
        print("Invalid message format: missing email, subject or message")
        ch.basic_ack(delivery_tag=method.delivery_tag)
        return

    send_email(email, subject, message)
    ch.basic_ack(delivery_tag=method.delivery_tag)
    print("Message processed and acknowledged.")

def main():
    print("Starting email notification consumer...")

    credentials = pika.PlainCredentials(RABBITMQ_USER, RABBITMQ_PASS)
    parameters = pika.ConnectionParameters(
        host=RABBITMQ_HOST,
        port=RABBITMQ_PORT,
        virtual_host=RABBITMQ_VHOST,
        credentials=credentials
    )

    try:
        connection = pika.BlockingConnection(parameters)
        print(f"Connected to RabbitMQ at {RABBITMQ_HOST}:{RABBITMQ_PORT}")
    except Exception as e:
        print(f"Failed to connect to RabbitMQ: {e}")
        sys.exit(1)

    channel = connection.channel()
    channel.queue_declare(queue='notifications', durable=True)

    print("Waiting for messages on 'notifications' queue...")
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(queue='notifications', on_message_callback=callback)

    try:
        channel.start_consuming()
    except KeyboardInterrupt:
        print("Interrupted, closing connection...")
        connection.close()
        sys.exit(0)
    except Exception as e:
        print(f"Error during consuming: {e}")
        connection.close()
        sys.exit(1)

if __name__ == "__main__":
    main()
