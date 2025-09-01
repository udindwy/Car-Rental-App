<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Vehicle;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'transmission' => ['required', Rule::in(['AT', 'MT'])],
            'fuel' => ['required', Rule::in(['bensin', 'diesel', 'hybrid', 'ev'])],
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
            'seats' => 'required|integer|min:1',
            'base_price_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',

            // Pastikan aturan untuk array sudah benar
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
