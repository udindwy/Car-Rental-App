<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dasbor admin dengan data KPI dan aktivitas terbaru.
     */
    public function index()
    {
        try {
            // --- 1. Kalkulasi Pendapatan Bersih ---
            // Total pemasukan dari pesanan yang statusnya 'completed'
            $totalIncome = Booking::where('status', 'completed')->sum('grand_total');
            // Total pengeluaran dari semua transaksi refund
            $totalRefunds = Payment::where('status', 'refunded')->sum('amount');
            // Pendapatan bersih adalah pemasukan dikurangi pengeluaran refund
            $totalRevenue = $totalIncome - $totalRefunds;

            // --- 2. Kalkulasi KPI Lainnya ---
            $totalBookings = Booking::count();
            $activeVehicles = Vehicle::where('status', 'active')->count();
            $totalVehicles = Vehicle::count();
            $vehiclesOnRent = Booking::where('status', 'on_rent')->count();
            $occupancyRate = ($totalVehicles > 0) ? ($vehiclesOnRent / $totalVehicles) * 100 : 0;
            $todayBookings = Booking::whereDate('created_at', today())->count();

            // --- 3. Mengambil Aktivitas Terbaru ---
            $recentBookings = Booking::with(['user', 'vehicle'])->latest()->take(5)->get();
            $recentVehicles = Vehicle::with('brand')->latest()->take(5)->get();

            // Gabungkan kedua koleksi, urutkan berdasarkan tanggal dibuat, dan ambil 5 teratas
            $activities = $recentBookings->concat($recentVehicles)
                ->sortByDesc('created_at')
                ->take(5);

            // --- 4. Menyiapkan Data untuk Grafik ---
            $bookingsChart = Booking::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
                ->where('created_at', '>=', now()->subDays(6)) // Mengambil data 7 hari termasuk hari ini
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $chartLabels = $bookingsChart->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
            $chartData = $bookingsChart->pluck('count');
        } catch (QueryException $e) {
            // --- 5. Penanganan Error (jika tabel tidak ada atau error query) ---
            // Siapkan data default agar halaman tidak rusak.
            $totalRevenue = 0;
            $totalBookings = 0;
            $activeVehicles = 0;
            $occupancyRate = 0;
            $todayBookings = 0;
            $activities = collect(); // Kirim collection kosong
            $chartLabels = collect();
            $chartData = collect();
        }

        // --- 6. Mengirim Semua Data ke View ---
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
