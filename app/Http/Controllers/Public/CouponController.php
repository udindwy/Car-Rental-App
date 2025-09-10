<?php
// app/Http/Controllers/Public/CouponController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validateCoupon(Request $request, CouponService $couponService)
    {
        // Validasi input awal
        $request->validate([
            'coupon_code' => 'required|string',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Panggil service untuk melakukan validasi mendalam
        $result = $couponService->validate(
            $request->input('coupon_code'),
            $request->input('total_price')
        );

        // Kirim respons berdasarkan hasil dari service
        if (!$result['success']) {
            // Kirim pesan error jika tidak valid
            return response()->json(['message' => $result['message']], 422);
        }

        // Kirim data diskon jika valid
        return response()->json($result);
    }
}
