<?php
namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher
{
    protected $connection;
    protected $channel;
    protected $queue = 'notifications';

    public function __construct()
    {
        $host = env('RABBITMQ_HOST', 'rabbitmq');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'guest');
        $pass = env('RABBITMQ_PASS', 'guest');
        $vhost = env('RABBITMQ_VHOST', '/');

        $this->connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
        $this->channel = $this->connection->channel();

        $this->channel->queue_declare($this->queue, false, true, false, false);
    }

    public function publishNotification(string $email, string $subject, string $message)
    {
        $data = json_encode([
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        $msg = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

        $this->channel->basic_publish($msg, '', $this->queue);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
