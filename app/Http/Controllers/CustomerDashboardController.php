<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['vehicle.brand', 'payment'])
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('bookings'));
    }

    public function showBookingDetail(Booking $booking)
    {
        // Keamanan: Pastikan user hanya bisa melihat booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Eager load semua relasi yang dibutuhkan
        $booking->load(['vehicle.brand', 'vehicle.images', 'payment', 'extras', 'pickupBranch', 'dropoffBranch']);

        return view('public.booking-detail', compact('booking'));
    }
}
