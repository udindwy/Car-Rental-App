<?php

namespace App\Providers;

// PENTING: Pastikan kedua model ini di-import
use App\Models\Booking;
use App\Observers\BookingObserver;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    // Kita akan kosongkan ini untuk menghindari masalah cache/bootstrap
    protected $observers = [
        // Booking::class => [BookingObserver::class], // Dikosongkan
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // =========================================================================
        // DAFTARKAN OBSERVER SECARA MANUAL DI SINI
        // Ini adalah cara yang lebih pasti dan akan menyelesaikan masalah registrasi.
        // =========================================================================
        Booking::observe(BookingObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
