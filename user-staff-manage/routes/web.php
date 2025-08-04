<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendNotificationEmail;
use App\Services\RabbitMQPublisher;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

Route::redirect('/', '/admin/login');
// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('api')->group(function () {
    Route::controller(ApiController::class)->group(function () {
        Route::get('/system-check', 'systemCheck');
        Route::get('/user/check', 'tokenCheck');
        Route::post('/user/verify', 'login')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });
});

Route::get('/test-rabbit-old', function () {
    dispatch(new \App\Jobs\TestRabbitJob());
    // SendNotificationEmail::dispatch(
    //     'kboat14@outlook.com',
    //     'Subject Here',
    //     'This is the body of the message.'
    // )->onQueue('notifications');
    return response()->json(['message' => 'RabbitMQ test job dispatched! ' . now()]);
});

Route::get('/test-rabbit', function () {

    $connection = new AMQPStreamConnection(
        env('RABBITMQ_HOST', 'rabbitmq'),
        env('RABBITMQ_PORT', 5672),
        env('RABBITMQ_USER', 'admin'),
        env('RABBITMQ_PASSWORD', 'adminRabbit'),
        env('RABBITMQ_VHOST', '/')
    );
    $channel = $connection->channel();

    $channel->queue_declare('notifications', false, true, false, false);

    $data = json_encode([
        'email' => 'boatinc14@yahoo.com',
        'subject' => 'Testing User Staff Manage',
        'message' => 'This is a test message for RabbitMQ integration.'
    ]);

    $msg = new AMQPMessage($data, ['delivery_mode' => 2]);
    $channel->basic_publish($msg, '', 'notifications');

    $channel->close();
    $connection->close();

    return 'Published raw JSON to queue.';

});
