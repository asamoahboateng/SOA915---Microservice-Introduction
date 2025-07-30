<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::controller(ApiController::class)->group(function () {
        Route::get('/system-check', 'systemCheck');
        Route::get('/user/check', 'tokenCheck');
        Route::post('/user/verify', 'login')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });
});
