<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Public Controllers ---
use App\Http\Controllers\Public\PageController as PublicPageController;
use App\Http\Controllers\Public\VehicleController as PublicVehicleController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\ReviewController as PublicReviewController;
use App\Http\Controllers\CustomerDashboardController;


// --- Admin Controllers ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// == PUBLIC ROUTES ==
Route::controller(PublicVehicleController::class)->group(function () {
    Route::get('/', 'home')->name('home');
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
    Route::get('/booking/{booking}/review', [PublicReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [PublicReviewController::class, 'store'])->name('review.store');
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
    Route::post('vehicles/{vehicle}/update-status', [VehicleController::class, 'updateStatus'])->name('vehicles.updateStatus');

    // Manajemen Ketersediaan Mobil
    Route::get('vehicles/{vehicle}/availability', [AvailabilityController::class, 'index'])->name('vehicles.availability');
    Route::post('vehicles/{vehicle}/availability', [AvailabilityController::class, 'store'])->name('vehicles.availability.store');
    Route::delete('availability/{availability}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');

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
    Route::get('settings/remove-logo', [SettingController::class, 'removeLogo'])->name('settings.remove-logo');

    // Laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/bookings', [ReportController::class, 'exportBookings'])->name('reports.export.bookings');

    // ▼▼▼ RUTE INI SEKARANG DILINDUNGI ▼▼▼
    Route::get('reports/revenue', [ReportController::class, 'exportRevenue'])
        ->name('reports.export.revenue')
        ->middleware('can:exportRevenue,' . \App\Models\Report::class);

    Route::get('reports/occupancy', [ReportController::class, 'exportOccupancy'])->name('reports.export.occupancy');
    Route::get('reports/coupon-usage', [ReportController::class, 'exportCouponUsage'])->name('reports.export.coupon_usage');
});

// Authentication Routes (Generated by Breeze)
require __DIR__ . '/auth.php';
