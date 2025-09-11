<?php
// app/Services/CouponService.php

namespace App\Services;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    public function validate(string $couponCode, float $totalPrice)
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Kode kupon tidak ditemukan.'];
        }
        if ($coupon->status !== 'active') {
            return ['success' => false, 'message' => 'Kupon ini sudah tidak aktif.'];
        }
        if ($coupon->end_date && $coupon->end_date->isPast()) {
            return ['success' => false, 'message' => 'Kupon sudah kedaluwarsa.'];
        }
        if ($coupon->max_usage !== null && $coupon->used_count >= $coupon->max_usage) {
            return ['success' => false, 'message' => 'Kuota pemakaian kupon sudah habis.'];
        }
        if ($coupon->min_total !== null && $totalPrice < $coupon->min_total) {
            $minTotalFormatted = number_format($coupon->min_total, 0, ',', '.');
            return ['success' => false, 'message' => "Minimal total belanja untuk kupon ini adalah Rp {$minTotalFormatted}."];
        }

        $discountAmount = 0;
        if ($coupon->type === 'flat') {
            $discountAmount = $coupon->value;
        } elseif ($coupon->type === 'percent') {
            $discountAmount = ($totalPrice * $coupon->value) / 100;
        }

        $discountAmount = min($discountAmount, $totalPrice);
        $newTotal = $totalPrice - $discountAmount;

        return [
            'success'         => true,
            'message'         => 'Kupon berhasil diterapkan!',
            'discount_amount' => $discountAmount,
            'new_total'       => $newTotal,
            'coupon'          => $coupon,
        ];
    }
}
