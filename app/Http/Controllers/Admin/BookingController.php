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
     * Display a listing of the resource with search functionality.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'vehicle']);

        // Filter berdasarkan kata kunci pencarian
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicle', function ($vehicleQuery) use ($search) {
                        $vehicleQuery->where('name', 'like', "%{$search}%");
                    });
            });
        });

        // Filter berdasarkan status
        $query->when($request->status, function ($q, $status) {
            return $q->where('status', $status);
        });

        // Filter berdasarkan rentang tanggal sewa (pickup)
        $query->when($request->start_date, function ($q, $date) {
            return $q->whereDate('pickup_datetime', '>=', $date);
        });
        $query->when($request->end_date, function ($q, $date) {
            return $q->whereDate('pickup_datetime', '<=', $date);
        });

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        // Mengambil data yang dibutuhkan untuk dropdown di form edit
        $booking->load('payments'); // Memuat riwayat pembayaran
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
     * Store a new payment for the specified booking.
     */
    public function storePayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in(['cash', 'transfer', 'gateway'])],
            'notes' => 'nullable|string|max:255',
        ]);

        // 1. Catat transaksi pembayaran baru
        $booking->payments()->create([
            'amount' => $request->payment_amount,
            'method' => $request->payment_method,
            'status' => 'paid',
            'paid_at' => now(),
            'reference' => $request->notes,
        ]);

        // 2. Hitung ulang dan update status pembayaran di booking
        $totalPaid = $booking->payments()->where('status', 'paid')->sum('amount');
        $totalRefunded = $booking->payments()->where('status', 'refunded')->sum('amount');
        $netPaid = $totalPaid - $totalRefunded;

        if ($netPaid >= $booking->grand_total) {
            $booking->payment_status = 'paid';
        } elseif ($netPaid > 0) {
            $booking->payment_status = 'partial';
        } else {
            $booking->payment_status = 'unpaid';
        }
        $booking->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
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
