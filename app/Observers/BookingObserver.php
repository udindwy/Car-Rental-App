<?php

namespace App\Observers;

use App\Models\Booking;
use App\Mail\BookingStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function created(Booking $booking): void
    {
        Log::info('Observer `created` terpanggil untuk Booking ID: ' . $booking->id);
        Log::info('Booking baru dibuat! Mencoba mengirim email ke: ' . $booking->user->email);

        try {
            Mail::to($booking->user->email)->send(new BookingStatusChanged($booking));
            Log::info('Email untuk booking baru berhasil dimasukkan ke antrian kirim.');
        } catch (\Exception $e) {
            Log::error('Gagal saat mengirim email untuk booking baru: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Booking "updating" event.
     * Kita memindahkan logika ke sini karena event 'updating' sudah terbukti berjalan.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function updating(Booking $booking): void
    {
        Log::info('Observer `updating` terpanggil untuk Booking ID: ' . $booking->id);

        // isDirty() berfungsi baik di 'updating' dan 'updated'
        if ($booking->isDirty('status')) {
            Log::info('Status berubah di event UPDATING! Mencoba mengirim email ke: ' . $booking->user->email);
            try {
                Mail::to($booking->user->email)->send(new BookingStatusChanged($booking));
                Log::info('Email perubahan status berhasil dimasukkan ke antrian kirim dari event UPDATING.');
            } catch (\Exception $e) {
                Log::error('Gagal saat mengirim email perubahan status dari event UPDATING: ' . $e->getMessage());
            }
        } else {
            Log::info('Booking ID: ' . $booking->id . ' diupdate (updating), tetapi status tidak berubah. Email tidak dikirim.');
        }
    }

    /**
     * Handle the Booking "updated" event.
     * Method ini kita biarkan kosong untuk sementara.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function updated(Booking $booking): void
    {
        // Logika dipindahkan ke updating() untuk memastikan eksekusi.
        Log::info('Observer `updated` terpanggil (method ini sekarang kosong).');
    }
}
