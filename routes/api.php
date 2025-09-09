<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VehicleController;
use App\Http\Controllers\Api\MidtransWebhookController;

Route::post('/vehicles/{vehicle}/calculate-price', [VehicleController::class, 'calculatePrice'])
    ->name('api.vehicles.calculate-price');

Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle'])
    ->name('midtrans.notification');
