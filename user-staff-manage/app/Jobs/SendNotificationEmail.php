<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable; // <-- this!
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $queue = 'notifications';

    protected $email;
    protected $subject;
    protected $message;

    public function __construct($email, $subject, $message)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function handle()
    {
        // We're just queueing the raw payload
        // The Python consumer will handle the actual sending
        // So we don't do anything here
    }

    public function middleware()
    {
        return [];
    }

    public function tags()
    {
        return ['notification-email'];
    }

    public function payload()
    {
        return [
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];
    }
}
