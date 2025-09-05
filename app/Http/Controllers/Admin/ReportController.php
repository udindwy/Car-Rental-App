<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\BookingsExport;
use App\Exports\CouponUsageExport;
use App\Exports\OccupancyExport;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama untuk laporan.
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Mengekspor data pemesanan ke file CSV.
     */
    public function exportBookings()
    {
        return Excel::download(new BookingsExport, 'laporan-pemesanan-' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Mengekspor data pendapatan (transaksi) ke file CSV.
     * (METHOD YANG HILANG DITAMBAHKAN DI SINI)
     */
    public function exportRevenue()
    {
        return Excel::download(new RevenueExport, 'laporan-pendapatan-' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Mengekspor data okupansi kendaraan ke file CSV.
     */
    public function exportOccupancy()
    {
        return Excel::download(new OccupancyExport, 'laporan-okupansi-' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Mengekspor data pemakaian kupon ke file CSV.
     */
    public function exportCouponUsage()
    {
        return Excel::download(new CouponUsageExport, 'laporan-pemakaian-kupon-' . now()->format('Y-m-d') . '.csv');
    }
}
