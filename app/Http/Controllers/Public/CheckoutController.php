<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Extra;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Services\PriceCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Mengatur konfigurasi Midtrans saat controller diinisialisasi.
     */
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Menampilkan halaman checkout.
     */
    public function show(Request $request, PriceCalculatorService $calculator)
    {
        $request->validate([
            'vehicle_id'       => 'required|exists:vehicles,id',
            'pickup_datetime'  => 'required|date',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
            'extras'           => 'nullable|array'
        ]);

        $vehicle     = Vehicle::findOrFail($request->vehicle_id);
        $pickupDate  = $request->pickup_datetime;
        $dropoffDate = $request->dropoff_datetime;
        $extraIds    = $request->extras ?? [];

        // Hitung ulang harga untuk keamanan
        $priceDetails = $calculator->calculate($vehicle, $pickupDate, $dropoffDate, $extraIds);

        if (isset($priceDetails['error'])) {
            return redirect()
                ->route('vehicle.show', $vehicle->slug)
                ->with('error', $priceDetails['error']);
        }

        return view('public.checkout', compact('vehicle', 'priceDetails', 'pickupDate', 'dropoffDate', 'extraIds'));
    }

    /**
     * Menyimpan data booking dan menangani semua metode pembayaran melalui AJAX.
     */
    public function store(StoreBookingRequest $request, PriceCalculatorService $calculator)
    {
        $validated = $request->validated();
        $vehicle   = Vehicle::findOrFail($validated['vehicle_id']);

        // Hitung ulang harga di backend untuk validasi akhir
        $priceDetails = $calculator->calculate(
            $vehicle,
            $validated['pickup_datetime'],
            $validated['dropoff_datetime'],
            $validated['extras'] ?? []
        );

        if (isset($priceDetails['error'])) {
            return response()->json(['error' => $priceDetails['error']], 422);
        }

        // Simpan dokumen
        $ktpPath = $request->file('ktp')->store('documents', 'public');
        $simPath = $request->file('sim')->store('documents', 'public');

        $user = auth()->user();

        // Sekarang update data user tersebut
        $user->update([
            'ktp_path' => $ktpPath,
            'sim_path' => $simPath,
        ]);

        if ($user && empty($user->phone_number)) {
            $user->update([
                'phone_number' => $validated['phone']
            ]);
        }

        // Simpan booking
        $booking = Booking::create([
            'user_id'           => auth()->id(),
            'vehicle_id'        => $vehicle->id,
            'branch_pickup_id'  => $vehicle->branch_id,
            'branch_dropoff_id' => $vehicle->branch_id,
            'pickup_datetime'   => $validated['pickup_datetime'],
            'dropoff_datetime'  => $validated['dropoff_datetime'],
            'duration_days'     => $priceDetails['duration'],
            'subtotal'          => $priceDetails['subtotal'],
            'extras_total'      => $priceDetails['extras_cost'],
            'discount_total'    => 0, // Placeholder
            'grand_total'       => $priceDetails['total_price'],
            'status'            => 'pending',
            'phone_number'      => $validated['phone'],
            'ktp_path'          => $ktpPath,
            'sim_path'          => $simPath,
        ]);

        // Simpan extras
        if (!empty($validated['extras'])) {
            $selectedExtras = Extra::find($validated['extras']);
            $extrasToAttach = [];
            foreach ($selectedExtras as $extra) {
                $extrasToAttach[$extra->id] = ['price' => $extra->price, 'total' => $extra->price];
            }
            $booking->extras()->attach($extrasToAttach);
        }

        $paymentMethod = $validated['payment_method'];

        if ($paymentMethod === 'gateway') {
            // --- ALUR MIDTRANS ---
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'method'     => 'gateway',
                'amount'     => $booking->grand_total,
                'status'     => 'unpaid',
                'reference'  => 'RENTAL-' . Str::random(5) . '-' . $booking->id,
            ]);

            $params = [
                'transaction_details' => [
                    'order_id'     => $payment->reference,
                    'gross_amount' => (int) $payment->amount,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email'      => auth()->user()->email,
                    'phone'      => $validated['phone'],
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                return response()->json(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } elseif ($paymentMethod === 'transfer') {
            // --- ALUR TRANSFER MANUAL ---
            Payment::create([
                'booking_id' => $booking->id,
                'method'     => 'transfer',
                'amount'     => $booking->grand_total,
                'status'     => 'unpaid',
            ]);

            // Berikan URL redirect ke frontend
            return response()->json(['redirect_url' => route('booking.transfer', $booking->id)]);
        } elseif ($paymentMethod === 'cash') {
            // --- ALUR BAYAR DI TEMPAT ---
            $booking->update(['status' => 'confirmed']);

            Payment::create([
                'booking_id' => $booking->id,
                'method'     => 'cash',
                'amount'     => $booking->grand_total,
                'status'     => 'unpaid',
            ]);

            // Berikan URL redirect ke frontend
            return response()->json(['redirect_url' => route('booking.cash', $booking->id)]);
        }

        // Fallback jika metode pembayaran tidak valid
        return response()->json(['error' => 'Metode pembayaran tidak valid'], 400);
    }

    /**
     * Menampilkan halaman instruksi untuk transfer bank.
     */
    public function transferInstruction(Booking $booking)
    {
        // Pastikan hanya user yang bersangkutan yang bisa melihat halaman ini
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.booking-success-transfer', compact('booking'));
    }

    /**
     * Menangani redirect setelah booking cash berhasil.
     */
    public function cashSuccess(Booking $booking)
    {
        // Pastikan hanya user yang bersangkutan yang bisa melihat halaman ini
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('home')->with('success', 'Pesanan Anda dengan ID #' . $booking->id . ' telah dikonfirmasi! Silakan siapkan pembayaran tunai saat pengambilan mobil.');
    }
}
