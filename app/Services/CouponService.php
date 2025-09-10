<?php
// app/Services/CouponService.php

namespace App\Services;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    public function validate(string $couponCode, float $totalPrice)
    {
        // 1. Cari kupon berdasarkan kode
        $coupon = Coupon::where('code', $couponCode)->first();

        // 2. Lakukan serangkaian pengecekan
        if (!$coupon) {
            return ['success' => false, 'message' => 'Kode kupon tidak ditemukan.'];
        }

        // [FIXED] Menggunakan 'status' bukan 'is_active'
        // Asumsi status 'active' berarti aktif
        if ($coupon->status !== 'active') {
            return ['success' => false, 'message' => 'Kupon ini sudah tidak aktif.'];
        }

        // [FIXED] Menggunakan 'end_date' bukan 'expires_at'
        if ($coupon->end_date && $coupon->end_date->isPast()) {
            return ['success' => false, 'message' => 'Kupon sudah kedaluwarsa.'];
        }

        // [FIXED] Menggunakan 'max_usage' dan 'used_count'
        if ($coupon->max_usage !== null && $coupon->used_count >= $coupon->max_usage) {
            return ['success' => false, 'message' => 'Kuota pemakaian kupon sudah habis.'];
        }

        // [FIXED] Menggunakan 'min_total' bukan 'min_purchase'
        if ($coupon->min_total !== null && $totalPrice < $coupon->min_total) {
            $minTotalFormatted = number_format($coupon->min_total, 0, ',', '.');
            return ['success' => false, 'message' => "Minimal total belanja untuk kupon ini adalah Rp {$minTotalFormatted}."];
        }

        // 3. Jika semua pengecekan lolos, hitung diskon
        $discountAmount = 0;
        if ($coupon->type === 'fixed') {
            $discountAmount = $coupon->value;
        } elseif ($coupon->type === 'percent') {
            $discountAmount = ($totalPrice * $coupon->value) / 100;
        }

        // Pastikan diskon tidak melebihi total harga
        $discountAmount = min($discountAmount, $totalPrice);

        $newTotal = $totalPrice - $discountAmount;

        // 4. Kembalikan hasil yang sukses
        return [
            'success'         => true,
            'message'         => 'Kupon berhasil diterapkan!',
            'discount_amount' => $discountAmount,
            'new_total'       => $newTotal,
            'coupon'          => $coupon,
        ];
    }
}
