<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Kalkulasi Data KPI
            $totalRevenue = Booking::where('status', 'completed')->sum('grand_total');
            $totalBookings = Booking::count();
            $activeVehicles = Vehicle::where('status', 'active')->count();
            $totalVehicles = Vehicle::count();
            $vehiclesOnRent = Booking::where('status', 'on_rent')->count();
            $occupancyRate = ($totalVehicles > 0) ? ($vehiclesOnRent / $totalVehicles) * 100 : 0;
            $todayBookings = Booking::whereDate('created_at', today())->count();

            // Ambil Aktivitas Terbaru
            $recentBookings = Booking::with(['user', 'vehicle'])->latest()->take(5)->get();
            $recentVehicles = Vehicle::with('brand')->latest()->take(5)->get();
            $activities = $recentBookings->concat($recentVehicles)
                ->sortByDesc('created_at')
                ->take(5);

            // Data untuk Grafik
            $bookingsChart = Booking::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
                ->where('created_at', '>=', now()->subDays(6))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $chartLabels = $bookingsChart->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
            $chartData = $bookingsChart->pluck('count');
        } catch (QueryException $e) {
            // Data Default jika terjadi error query
            $totalRevenue = 0;
            $totalBookings = 0;
            $activeVehicles = 0;
            $occupancyRate = 0;
            $todayBookings = 0;
            $activities = collect();
            $chartLabels = collect();
            $chartData = collect();
        }

        // Kirim Semua Variabel ke View
        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'activeVehicles',
            'occupancyRate',
            'todayBookings',
            'activities',
            'chartLabels',
            'chartData'
        ));
    }
}
