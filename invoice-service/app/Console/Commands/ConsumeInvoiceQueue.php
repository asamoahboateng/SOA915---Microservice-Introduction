<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Models\Invoice;

class ConsumeInvoiceQueue extends Command
{
    protected $signature = 'rabbitmq:consume-invoice';
    protected $description = 'Consume invoice queue and create invoices';

    public function handle()
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );

        $channel = $connection->channel();
        $channel->queue_declare('invoice', false, true, false, false);

        $this->info('Waiting for messages in invoice queue...');

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);

            Log::info("Received message: " . now() .' '. $msg->body);
            if ($data) {

                try {
                    Invoice::create([
                        'client_name'    => $data['client_name'],
                        'client_phone'   => $data['client_phone'],
                        'client_email'   => $data['client_email'],
                        'service_name'   => $data['service_name'],
                        'cost'   => $data['service_cost'],
                        'service_id'     => $data['service_id'],
                        'booking_uid'    => $data['booking_uid'],
                        'status'          => 'pending',
                    ]);

                    $this->info("Invoice created for: " . $data['client_name']);
                    Log::info('Invoice created for: ' . $data['client_name']);
                    $msg->ack();

                } catch (\Exception $e) {
                    Log::error('Invoice creation failed', ['error' => $e->getMessage()]);
                    $this->info("Invoice creation failed for: " . $data['client_name'] . ' - ' . $e->getMessage());
                    // You can decide to nack (requeue) or ack (discard) based on the error
                    $msg->nack(false, false); // won't requeue
                }
            } else {
                Log::error('Invalid JSON received', ['message' => $msg->body]);
                $this->error('Invalid JSON received');
                $msg->nack();
            }
        };

        $channel->basic_consume('invoice', '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

}
