<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/* Sends a message to the specified RabbitMQ queue.
 *
 * @param string $queue_name The name of the RabbitMQ queue.
 * @param array $message_data The data to be sent in the message.
 * @return void
 */
if (!function_exists('message_to_queue')) {
    function message_to_queue(string $queue_name, array $message_data) :void
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'admin'),
            env('RABBITMQ_PASSWORD', 'adminRabbit'),
            env('RABBITMQ_VHOST', '/')
        );
        $channel = $connection->channel();

        $channel->queue_declare($queue_name, false, true, false, false);

        $data = json_encode($message_data);

        $msg = new AMQPMessage($data, ['delivery_mode' => 2]);
        $channel->basic_publish($msg, '', $queue_name);

        $channel->close();
        $connection->close();

        \Illuminate\Support\Facades\Log::info("Message sent to queue: $queue_name", [
            'message' => $data,
        ]);
        echo "Message sent to queue: $queue_name\n";
//        $this->info("Message sent to queue: $queue_name");
//        return 'Published raw JSON to queue.';
    }
}
