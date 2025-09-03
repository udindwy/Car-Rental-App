<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data booking dengan relasi untuk efisiensi query
        $bookings = Booking::with(['user', 'vehicle'])->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     * (Fitur ini bisa dikembangkan nanti untuk membuat pesanan manual dari admin)
     */
    public function create()
    {
        // Logika untuk halaman create bisa ditambahkan di sini
        return redirect()->route('admin.bookings.index')->with('info', 'Fitur Tambah Pemesanan Manual belum diimplementasikan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logika untuk menyimpan booking baru dari admin
        return redirect()->route('admin.bookings.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        // Mengambil data yang dibutuhkan untuk dropdown di form edit
        $users = User::where('role', 'customer')->get();
        $vehicles = Vehicle::all(); // Mengambil semua mobil agar bisa diganti
        $branches = Branch::all();

        return view('admin.bookings.edit', compact('booking', 'users', 'vehicles', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Validasi data yang masuk, terutama status
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after_or_equal:pickup_datetime',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'on_rent', 'completed', 'cancelled'])],
            'notes' => 'nullable|string',
        ]);

        // Update data booking
        $booking->update($request->all());

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
        // Eager load relasi untuk ditampilkan di invoice
        $booking->load('user', 'vehicle.brand');

        $pdf = Pdf::loadView('admin.bookings.invoice', compact('booking'));

        // Tampilkan PDF di browser
        return $pdf->stream('invoice-' . $booking->id . '.pdf');
    }

    /**
     * Process a refund for the specified booking.
     */
    public function processRefund(Request $request, Booking $booking)
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:0',
            'refund_method' => ['required', Rule::in(['cash', 'transfer', 'gateway'])],
            'notes' => 'nullable|string|max:255',
        ]);

        // 1. Ubah status booking menjadi 'cancelled'
        $booking->update(['status' => 'cancelled']);

        // 2. Buat catatan pembayaran baru untuk refund
        $booking->payments()->create([
            'amount' => $request->refund_amount,
            'method' => $request->refund_method,
            'status' => 'refunded',
            'paid_at' => now(),
            'reference' => $request->notes,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pesanan berhasil dibatalkan dan refund dicatat.');
    }
}
