<?php
// app/Services/PriceCalculatorService.php

namespace App\Services;

use App\Models\Extra; // <-- TAMBAHKAN INI
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PriceCalculatorService
{
    public function calculate(Vehicle $vehicle, ?string $pickupDate, ?string $dropoffDate, array $extraIds = []): array
    {
        $validator = Validator::make(
            ['pickup' => $pickupDate, 'dropoff' => $dropoffDate],
            ['pickup' => 'required|date', 'dropoff' => 'required|date|after:pickup']
        );

        if ($validator->fails()) {
            return ['error' => $validator->errors()->first()];
        }

        try {
            $pickup = Carbon::parse($pickupDate, 'Asia/Jakarta');
            $dropoff = Carbon::parse($dropoffDate, 'Asia/Jakarta');
        } catch (\Exception $e) {
            return ['error' => 'Format tanggal tidak valid.'];
        }

        $durationInHours = $pickup->diffInHours($dropoff);
        $days = max(1, ceil($durationInHours / 24));
        $subtotal = $vehicle->base_price_day * $days;

        // --- LOGIKA BARU UNTUK EXTRAS ---
        $extrasCost = 0;
        $selectedExtras = Extra::find($extraIds);

        foreach ($selectedExtras as $extra) {
            if ($extra->price_type === 'per_hari') {
                $extrasCost += $extra->price * $days;
            } else { // 'per_sewa'
                $extrasCost += $extra->price;
            }
        }
        // --- AKHIR LOGIKA BARU ---

        $totalPrice = $subtotal + $extrasCost;

        return [
            'success' => true,
            'duration' => $days,
            'subtotal' => $subtotal,
            'extras_cost' => $extrasCost, // <-- Kirim biaya extras
            'total_price' => $totalPrice,
            'pickup_date_formatted' => $pickup->isoFormat('D MMMM YYYY, HH:mm'),
            'dropoff_date_formatted' => $dropoff->isoFormat('D MMMM YYYY, HH:mm'),
        ];
    }
}
