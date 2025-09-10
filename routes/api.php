<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VehicleController;
use App\Http\Controllers\Api\MidtransWebhookController;
use App\Http\Controllers\Public\CouponController; // <-- PASTIKAN INI YANG DIGUNAKAN

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/vehicles/{vehicle}/calculate-price', [VehicleController::class, 'calculatePrice'])
    ->name('api.vehicles.calculate-price');

// Route untuk menerima notifikasi dari Midtrans
Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle'])
    ->name('midtrans.notification');

// Route untuk memvalidasi kupon dari halaman checkout
Route::post('/coupons/validate', [CouponController::class, 'validateCoupon'])
    ->name('api.coupons.validate');
