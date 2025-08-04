<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
//Route::get('/', function () {
//    return view('welcome');
//});

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
   Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticateUser')->name('authenticateUser');
});


Route::controller(\App\Http\Controllers\DashboardController::class)->middleware(\App\Http\Middleware\CheckUserSession::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/logout', 'logout')->name('logout')->withoutMiddleware('auth');
    Route::get('/dashboard/overview', 'overview')->name('dashboard.overview');
    Route::get('/dashboard/settings', 'settings')->name('dashboard.settings');
});

Route::middleware(\App\Http\Middleware\CheckUserSession::class)->group(function () {
//    Route::get('/services', \App\Livewire\ServicesTable::class)->name('services');
//    Route::get('bookings', \App\Livewire\BookingsTable::class)->name('bookings');
    Route::get('/invoices', \App\Livewire\Invoices::class)->name('invoices');
});

Route::controller(\App\Http\Controllers\BookingController::class)->group(function () {
    Route::get('/book', 'create')->name('booking.create');
    Route::post('/book', 'store')->name('booking.store');
    Route::get('/book/confirmation/{booking}', 'confirmation')->name('booking.confirmation');
});


// API Controller
Route::prefix('api')->controller(\App\Http\Controllers\ApiController::class)->group(function () {
    Route::get('/bookings', 'getBookings')->name('api.bookings');
    Route::get('/booking/specify', 'getBooking')->name('api.specific.bookings');
    Route::get('/services', 'getServices')->name('api.services');
});
