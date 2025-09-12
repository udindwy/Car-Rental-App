<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menampilkan form untuk membuat ulasan baru.
     */
    public function create(Booking $booking)
    {
        // Lakukan serangkaian pengecekan keamanan
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }
        if ($booking->status !== 'completed') {
            return redirect()->route('dashboard')->with('error', 'Anda hanya bisa mengulas pesanan yang sudah selesai.');
        }
        if ($booking->review()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Pesanan ini sudah pernah Anda ulas.');
        }

        return view('public.create-review', compact('booking'));
    }

    /**
     * Menyimpan ulasan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id|unique:reviews,booking_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Keamanan tambahan, pastikan booking milik user
        $booking = Booking::findOrFail($validated['booking_id']);
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Simpan ulasan
        Review::create([
            'booking_id' => $booking->id,
            'vehicle_id' => $booking->vehicle_id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false, 
        ]);

        return redirect()->route('dashboard')->with('success', 'Terima kasih! Ulasan Anda telah kami terima dan akan dimoderasi.');
    }
}
