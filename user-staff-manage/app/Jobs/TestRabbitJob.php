<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestRabbitJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle()
    {
        \Log::info('✅ RabbitMQ test job executed!');
    }
}
