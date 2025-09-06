<?php

namespace App\Observers;

use App\Models\Booking;
use App\Mail\BookingStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Catat di log setiap kali ada booking yang di-update
        Log::info('Observer `updated` terpanggil untuk Booking ID: ' . $booking->id);

        // Periksa apakah kolom 'status' adalah salah satu kolom yang berubah.
        if ($booking->isDirty('status')) {
            Log::info('Status berubah! Mencoba mengirim email ke: ' . $booking->user->email);

            // Pastikan email pelanggan valid sebelum mengirim.
            if ($booking->user && $booking->user->email) {
                try {
                    Mail::to($booking->user->email)->send(new BookingStatusChanged($booking));
                    Log::info('Email untuk Booking ID ' . $booking->id . ' berhasil dimasukkan ke antrian kirim.');
                } catch (\Exception $e) {
                    // Jika gagal, catat error ke log agar bisa di-debug
                    Log::error('Gagal mengirim email notifikasi status booking: ' . $e->getMessage());
                }
            } else {
                Log::warning('Gagal mengirim email, user atau email tidak ditemukan untuk Booking ID: ' . $booking->id);
            }
        } else {
            Log::info('Status tidak berubah untuk Booking ID: ' . $booking->id . ', email tidak dikirim.');
        }
    }

    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        // Logika untuk mengirim email saat booking baru dibuat bisa ditambahkan di sini.
    }
}
