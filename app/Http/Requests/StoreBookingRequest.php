<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Izinkan semua pengguna yang sudah terotentikasi untuk membuat request ini
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            // Validasi data pesanan (dari hidden input)
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
            'grand_total' => 'required|numeric',
            'extras' => 'nullable|array',
            'extras.*' => 'exists:extras,id',

            // Validasi data diri penyewa
            'phone' => 'required|string|max:20',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048', // file gambar maks 2MB
            'sim' => 'required|image|mimes:jpeg,png,jpg|max:2048', // file gambar maks 2MB
        ];
    }
}
