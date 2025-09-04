<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda bisa mendaftarkan semua route untuk aplikasi Anda.
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- Armada Management ---
        Route::resource('brands', BrandController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('features', FeatureController::class);
        Route::resource('vehicles', VehicleController::class);

        // Pricing Management
        Route::get('vehicles/{vehicle}/pricing', [VehicleController::class, 'pricing'])->name('vehicles.pricing');
        Route::post('vehicles/{vehicle}/pricing', [VehicleController::class, 'storePricing'])->name('vehicles.storePricing');
        Route::delete('pricing-rules/{rule}', [VehicleController::class, 'destroyPricing'])->name('pricing-rules.destroy');

        // Availability & Blackouts
        Route::get('vehicles/{vehicle}/availability', [VehicleController::class, 'availability'])->name('vehicles.availability');
        Route::post('vehicles/{vehicle}/blackouts', [VehicleController::class, 'storeBlackout'])->name('vehicles.blackouts.store');
        Route::delete('blackouts/{blackout}', [VehicleController::class, 'destroyBlackout'])->name('blackouts.destroy');
        Route::get('blackouts/export', [VehicleController::class, 'exportBlackouts'])->name('blackouts.export');
        Route::get('blackouts/import', [VehicleController::class, 'showImportForm'])->name('blackouts.import.show');
        Route::post('blackouts/import', [VehicleController::class, 'importBlackouts'])->name('blackouts.import.store');

        // Bookings
        Route::resource('bookings', BookingController::class);
        Route::get('bookings/{booking}/invoice', [BookingController::class, 'generateInvoice'])->name('bookings.invoice');
        Route::post('bookings/{booking}/refund', [BookingController::class, 'processRefund'])->name('bookings.refund');
        Route::post('bookings/{booking}/payments', [BookingController::class, 'storePayment'])->name('bookings.payments.store');

        // Payments
        Route::resource('payments', PaymentController::class)->only(['index']);

        // Coupons
        Route::resource('coupons', CouponController::class);

        //Extras
        Route::resource('extras', ExtraController::class);
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
