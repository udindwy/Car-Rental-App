<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Payment; // Pastikan ini ada
use App\Models\User;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'vehicle'])->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $users = User::where('role', 'customer')->get();
        $vehicles = Vehicle::all();
        $branches = Branch::all();
        return view('admin.bookings.edit', compact('booking', 'users', 'vehicles', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after_or_equal:pickup_datetime',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'on_rent', 'completed', 'cancelled'])],
            'notes' => 'nullable|string',
        ]);

        $booking->update($data);
        return redirect()->route('admin.bookings.index')->with('success', 'Data pemesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Data pemesanan berhasil dihapus.');
    }

    /**
     * Generate a PDF invoice for the specified booking.
     */
    public function generateInvoice(Booking $booking)
    {
        $booking->load('user', 'vehicle.brand');
        $pdf = Pdf::loadView('admin.bookings.invoice', compact('booking'));
        return $pdf->stream('invoice-' . $booking->id . '.pdf');
    }

    /**
     * Process a refund for the specified booking.
     */
    public function processRefund(Request $request, Booking $booking)
    {
        // Validasi
        $data = $request->validate([
            'refund_amount' => 'required|numeric|min:0|max:' . $booking->grand_total,
            'notes' => 'nullable|string|max:255',
        ]);

        // 1. Ubah status pesanan menjadi 'cancelled'
        $booking->update(['status' => 'cancelled']);

        // 2. Catat transaksi refund di tabel payments
        $booking->payments()->create([
            'amount' => $data['refund_amount'],
            'method' => 'refund', // Menggunakan 'refund' sebagai penanda metode
            'status' => 'refunded',
            'notes' => $data['notes'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Pesanan telah dibatalkan dan refund berhasil dicatat.');
    }
}
