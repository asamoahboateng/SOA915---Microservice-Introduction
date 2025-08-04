from fastapi import FastAPI, Request
from fastapi.middleware.cors import CORSMiddleware
import pika
import json
import os

app = FastAPI()

# Allow CORS (optional: tighten later)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # or ["http://localhost:8000"] to restrict
    allow_methods=["POST"],
    allow_headers=["*"],
)

@app.post("/send-to-rabbitmq")
async def send_message(request: Request):
    data = await request.json()
    message = json.dumps(data)

    try:
        connection = pika.BlockingConnection(
            pika.ConnectionParameters(host=os.getenv("RABBIT_HOST", "rabbitmq"))
        )
        channel = connection.channel()
        queue_name = os.getenv("QUEUE_NAME", "contact_queue")
        channel.queue_declare(queue=queue_name, durable=True)
        channel.basic_publish(
            exchange='',
            routing_key=queue_name,
            body=message,
            properties=pika.BasicProperties(delivery_mode=2)  # make message persistent
        )
        connection.close()
        return {"status": "Message sent to RabbitMQ"}
    except Exception as e:
        return {"error": str(e)}
