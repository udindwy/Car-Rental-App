<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Services\PriceCalculatorService;
use Carbon\Carbon;

class VehicleController extends Controller
{
    /**
     * Menampilkan katalog mobil dengan filter & sorting.
     */
    public function index(Request $request)
    {
        // Mulai query untuk mobil yang aktif
        $query = Vehicle::where('status', 'active')->with(['brand', 'category', 'images']);

        // Filter Ketersediaan
        $query->when($request->pickup_datetime && $request->dropoff_datetime, function ($q) use ($request) {
            try {
                $pickup = Carbon::parse($request->pickup_datetime);
                $dropoff = Carbon::parse($request->dropoff_datetime);

                // Cari mobil yang TIDAK MEMILIKI booking yang tumpang tindih
                $q->whereDoesntHave('bookings', function ($subQuery) use ($pickup, $dropoff) {
                    // MENGGUNAKAN NAMA KOLOM DARI MIGRasi bookings
                    $subQuery->where('dropoff_datetime', '>', $pickup)
                        ->where('pickup_datetime', '<', $dropoff);
                });

                // Cari juga mobil yang TIDAK MEMILIKI jadwal blackout yang tumpang tindih
                $q->whereDoesntHave('blackouts', function ($subQuery) use ($pickup, $dropoff) {
                    // MENGGUNAKAN NAMA KOLOM DARI MIGRasi vehicle_blackouts (ini sudah benar)
                    $subQuery->where('end_datetime', '>', $pickup)
                        ->where('start_datetime', '<', $dropoff);
                });
            } catch (\Exception $e) {
                // Abaikan jika format tanggal tidak valid
                return $q;
            }
        });

        // Terapkan filter berdasarkan request
        $query->when($request->brand, fn($q, $brand) => $q->where('brand_id', $brand));
        $query->when($request->category, fn($q, $category) => $q->where('category_id', $category));
        $query->when($request->transmission, fn($q, $transmission) => $q->where('transmission', 'like', "%$transmission%"));
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
        $vehicle->load(['brand', 'category', 'features', 'images', 'reviews.user', 'extras']);
        return view('public.vehicle-detail', compact('vehicle'));
    }

    /**
     * Menghitung harga sewa melalui API.
     */
    public function calculatePrice(Request $request, Vehicle $vehicle, PriceCalculatorService $calculator)
    {
        $pickupDate = $request->input('pickup_date');
        $dropoffDate = $request->input('dropoff_date');
        $extraIds = $request->input('extras', []);

        $result = $calculator->calculate($vehicle, $pickupDate, $dropoffDate, $extraIds);

        if (isset($result['error'])) {
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    public function home()
    {
        // Ambil 6 mobil terbaru sebagai mobil unggulan
        $featuredVehicles = Vehicle::with(['brand', 'images'])
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('public.home', compact('featuredVehicles'));
    }
}
