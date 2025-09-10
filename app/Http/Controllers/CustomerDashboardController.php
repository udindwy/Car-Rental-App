<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // Ambil booking HANYA untuk user yang sedang login
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['vehicle.brand', 'payment']) // Eager load untuk performa
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Paginasi

        return view('dashboard', compact('bookings'));
    }
}
