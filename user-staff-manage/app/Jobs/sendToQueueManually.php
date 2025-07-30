<?php
namespace App\Jobs;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

public function sendToQueueManually()
{
    $connection = new AMQPStreamConnection(
        'rabbitmq', 5672, 'admin', 'adminRabbit', '/'
    );
    $channel = $connection->channel();

    $channel->queue_declare('notifications', false, true, false, false);

    $data = json_encode([
        'email' => 'kboat14@outlook.com',
        'subject' => 'Subject Here',
        'message' => 'This is the body of the message'
    ]);

    $msg = new AMQPMessage($data, ['delivery_mode' => 2]);
    $channel->basic_publish($msg, '', 'notifications');

    $channel->close();
    $connection->close();

    return 'Published raw JSON to queue.';
}
