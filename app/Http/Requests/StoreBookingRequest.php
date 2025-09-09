<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Menyiapkan data untuk validasi.
     *
     * Metode ini akan berjalan SEBELUM aturan validasi dieksekusi.
     */
    protected function prepareForValidation()
    {
        // Periksa apakah input 'extras' ada dan merupakan array
        if ($this->input('extras') && is_array($this->input('extras'))) {
            // Filter array 'extras' untuk menghapus semua nilai kosong/null
            $this->merge([
                'extras' => array_filter($this->input('extras'))
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
            'grand_total' => 'required|numeric',
            'extras' => 'nullable|array',
            'extras.*' => 'exists:extras,id',

            'phone' => 'required|string|max:20',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sim' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            'payment_method' => 'required|string|in:gateway,transfer,cash',
        ];
    }
}
