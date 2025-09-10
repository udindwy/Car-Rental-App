<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Public Controllers ---
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\Public\PageController as PublicPageController;
use App\Http\Controllers\Public\VehicleController as PublicVehicleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == PUBLIC ROUTES ==
Route::controller(PublicVehicleController::class)->group(function () {
    Route::get('/', 'index')->name('home'); // Asumsi method index di VehicleController menampilkan landing page
    Route::get('/catalog', 'index')->name('catalog');
    Route::get('/mobil/{vehicle:slug}', 'show')->name('vehicle.show');
});

Route::controller(CheckoutController::class)->middleware('auth')->group(function () {
    Route::get('/checkout', 'show')->name('checkout.show');
    Route::post('/checkout', 'store')->name('checkout.store');
});

Route::controller(CheckoutController::class)->middleware('auth')->prefix('booking')->name('booking.')->group(function () {
    Route::get('/transfer/{booking}', 'transferInstruction')->name('transfer');
    Route::get('/cash/{booking}', 'cashSuccess')->name('cash');
});

// Halaman Statis
Route::controller(PublicPageController::class)->group(function () {
    Route::get('/tentang-kami', 'about')->name('about');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/syarat-dan-ketentuan', 'terms')->name('terms');
    Route::get('/kontak', 'contact')->name('contact');
});


// == AUTHENTICATED CUSTOMER ROUTES ==
Route::middleware(['auth', 'verified', 'redirect.if.admin'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/booking/{booking}', [CustomerDashboardController::class, 'showBookingDetail'])->name('booking.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// == ADMIN PANEL ROUTES ==
Route::middleware(['auth', 'verified', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Manajemen Armada
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('features', FeatureController::class);
    Route::resource('extras', ExtraController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::get('vehicles/{vehicle}/pricing', [VehicleController::class, 'pricing'])->name('vehicles.pricing');
    Route::post('vehicles/{vehicle}/pricing', [VehicleController::class, 'storePricing'])->name('vehicles.storePricing');
    Route::delete('pricing-rules/{rule}', [VehicleController::class, 'destroyPricing'])->name('pricing-rules.destroy');
    Route::get('vehicles/{vehicle}/availability', [VehicleController::class, 'availability'])->name('vehicles.availability');
    Route::post('vehicles/{vehicle}/blackouts', [VehicleController::class, 'storeBlackout'])->name('vehicles.blackouts.store');
    Route::delete('blackouts/{blackout}', [VehicleController::class, 'destroyBlackout'])->name('blackouts.destroy');

    // Manajemen Transaksi
    Route::resource('bookings', BookingController::class);
    Route::get('bookings/{booking}/invoice', [BookingController::class, 'generateInvoice'])->name('bookings.invoice');
    Route::post('bookings/{booking}/refund', [BookingController::class, 'processRefund'])->name('bookings.refund');
    Route::post('bookings/{booking}/payments', [BookingController::class, 'storePayment'])->name('bookings.payments.store');
    Route::resource('payments', PaymentController::class)->only(['index']);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class)->only(['index', 'update', 'destroy']);


    // Manajemen Pengguna
    Route::resource('users', UserController::class);

    // Manajemen Konten & Pengaturan
    Route::resource('pages', PageController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/bookings', [ReportController::class, 'exportBookings'])->name('reports.export.bookings');
    Route::get('reports/revenue', [ReportController::class, 'exportRevenue'])->name('reports.export.revenue');
    Route::get('reports/occupancy', [ReportController::class, 'exportOccupancy'])->name('reports.export.occupancy');
    Route::get('reports/coupon-usage', [ReportController::class, 'exportCouponUsage'])->name('reports.export.coupon_usage');
});

// Authentication Routes (Generated by Breeze)
require __DIR__ . '/auth.php';
