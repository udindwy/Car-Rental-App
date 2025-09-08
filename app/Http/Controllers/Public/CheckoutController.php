<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Payment; // <-- Import model Payment
use App\Services\PriceCalculatorService;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <-- Import Str untuk Order ID

// Import Midtrans
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function show(Request $request, PriceCalculatorService $calculator)
    {
        // Validasi input dasar dari URL
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
            'extras' => 'nullable|array'
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $pickupDate = $request->pickup_datetime;
        $dropoffDate = $request->dropoff_datetime;
        $extraIds = $request->extras ?? [];

        // Hitung ulang harga di backend untuk keamanan
        $priceDetails = $calculator->calculate($vehicle, $pickupDate, $dropoffDate, $extraIds);

        // Jika ada error kalkulasi, kembalikan
        if (isset($priceDetails['error'])) {
            return redirect()->route('vehicle.show', $vehicle->slug)->with('error', $priceDetails['error']);
        }

        return view('public.checkout', compact('vehicle', 'priceDetails', 'pickupDate', 'dropoffDate', 'extraIds'));
    }

    public function store(StoreBookingRequest $request)
    {
        // 1. Validasi
        $validated = $request->validated();

        // 2. Simpan file KTP dan SIM
        $ktpPath = $request->file('ktp')->store('documents', 'public');
        $simPath = $request->file('sim')->store('documents', 'public');

        // 3. Buat booking baru
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $validated['vehicle_id'],
            'pickup_datetime' => $validated['pickup_datetime'],
            'dropoff_datetime' => $validated['dropoff_datetime'],
            'grand_total' => $validated['grand_total'],
            'status' => 'pending',
            'phone_number' => $validated['phone'],
            'ktp_path' => $ktpPath,
            'sim_path' => $simPath,
        ]);

        // 4. Lampirkan extras
        if (!empty($validated['extras'])) {
            $booking->extras()->attach($validated['extras']);
        }

        // --- MULAI LOGIKA MIDTRANS ---

        // 5. Buat catatan pembayaran
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method' => 'gateway',
            'amount' => $booking->grand_total,
            'status' => 'unpaid',
            // Buat ID unik untuk referensi transaksi Midtrans
            'reference' => 'RENTAL-' . Str::random(5) . '-' . $booking->id,
        ]);

        // 6. Siapkan parameter untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id' => $payment->reference, // Gunakan ID unik dari tabel payments
                'gross_amount' => (int) $payment->amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => $validated['phone'],
            ],
        ];

        try {
            // 7. Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 8. Kirim token ke frontend
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            // Jika gagal, kembalikan response error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
