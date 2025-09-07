<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Menampilkan katalog mobil dengan filter & sorting.
     */
    public function index(Request $request)
    {
        // Mulai query untuk mobil yang aktif
        $query = Vehicle::where('status', 'active')->with(['brand', 'category', 'images']);

        // Terapkan filter berdasarkan request
        $query->when($request->brand, fn($q, $brand) => $q->where('brand_id', $brand));
        $query->when($request->category, fn($q, $category) => $q->where('category_id', $category));
        $query->when($request->transmission, fn($q, $transmission) => $q->where('transmission', $transmission));
        $query->when($request->price_min, fn($q, $price) => $q->where('base_price_day', '>=', $price));
        $query->when($request->price_max, fn($q, $price) => $q->where('base_price_day', '<=', $price));

        // Terapkan pengurutan
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('base_price_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price_day', 'desc');
                break;
            default:
                $query->latest(); // Terbaru (default)
        }

        $vehicles = $query->paginate(12)->withQueryString();

        // Ambil data untuk filter di sidebar
        $brands = Brand::all();
        $categories = Category::all();

        return view('public.catalog', compact('vehicles', 'brands', 'categories'));
    }

    /**
     * Menampilkan halaman detail untuk satu mobil.
     */
    public function show(Vehicle $vehicle)
    {
        // Eager load semua relasi yang dibutuhkan untuk ditampilkan di halaman detail
        $vehicle->load(['brand', 'category', 'features', 'images', 'reviews.user']);

        return view('public.vehicle-detail', compact('vehicle'));
    }
}
