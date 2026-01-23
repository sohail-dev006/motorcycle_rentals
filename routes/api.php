<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;

Route::get('/bookings', [BookingController::class, 'index']);
