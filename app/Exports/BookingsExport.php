<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua data booking beserta relasinya
        return Booking::with(['user', 'vehicle.brand', 'vehicle.category', 'coupon'])->get();
    }

    /**
     * Menentukan baris header untuk file CSV.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Booking',
            'Nama Pelanggan',
            'Email Pelanggan',
            'Nama Mobil',
            'Brand',
            'Kategori',
            'Tanggal Ambil',
            'Tanggal Kembali',
            'Durasi (Hari)',
            'Subtotal',
            'Total Diskon',
            'Grand Total',
            'Status Pesanan',
            'Status Pembayaran',
            'Kode Kupon',
            'Tanggal Dibuat',
        ];
    }

    /**
     * Memetakan data dari setiap baris collection ke format yang diinginkan.
     * @param Booking $booking
     * @return array
     */
    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->user->name ?? 'N/A',
            $booking->user->email ?? 'N/A',
            $booking->vehicle->name ?? 'N/A',
            $booking->vehicle->brand->name ?? 'N/A',
            $booking->vehicle->category->name ?? 'N/A',
            $booking->pickup_datetime->format('Y-m-d H:i'),
            $booking->dropoff_datetime->format('Y-m-d H:i'),
            $booking->duration_days,
            $booking->subtotal,
            $booking->discount_total,
            $booking->grand_total,
            $booking->status,
            $booking->payment_status,
            $booking->coupon->code ?? '-',
            $booking->created_at->format('Y-m-d H:i'),
        ];
    }

    /**
     * Mengatur delimiter CSV menjadi titik koma (;) agar kompatibel dengan Excel di Indonesia.
     * @return array
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
