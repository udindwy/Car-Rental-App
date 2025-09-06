<?php

namespace App\Providers;

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
     * KITA KOSONGKAN INI UNTUK SEMENTARA.
     * @var array
     */
    protected $observers = [
        // Booking::class => [BookingObserver::class], // Dikosongkan
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // --- PERUBAHAN UTAMA: DAFTARKAN OBSERVER SECARA MANUAL DI SINI ---
        // Baris ini secara eksplisit memberitahu Laravel:
        // "Untuk model Booking, pasang dan gunakan BookingObserver."
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