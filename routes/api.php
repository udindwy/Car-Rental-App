<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VehicleController;

Route::post('/vehicles/{vehicle}/calculate-price', [VehicleController::class, 'calculatePrice'])
    ->name('api.vehicles.calculate-price');
