<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessInvoice;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ListenForInvoice extends Command
{
    protected $signature = 'invoice:listen';
    protected $description = 'Listen to RabbitMQ invoice queue';

    public function handle()
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'admin'),
            env('RABBITMQ_PASSWORD', 'adminRabbit'),
            env('RABBITMQ_VHOST', '/')
        );

        $channel = $connection->channel();
        $channel->queue_declare('invoice', false, true, false, false);

        $channel->basic_consume('invoice', '', false, false, false, false, function ($msg) {
            $this->info("Received: " . $msg->body);
            $data = json_decode($msg->body, true);

            if ($data) {
                ProcessInvoice::dispatch($data);
            }

            $msg->ack();
        });

        $this->info('Waiting for messages on "invoice" queue...');

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
