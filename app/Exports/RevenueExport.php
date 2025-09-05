<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class RevenueExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua data pembayaran beserta relasi booking -> user & vehicle
        return Payment::with(['booking.user', 'booking.vehicle'])->latest('paid_at')->get();
    }

    /**
     * Menentukan baris header untuk file CSV.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'ID Booking',
            'Nama Pelanggan',
            'Nama Mobil',
            'Tipe Transaksi',
            'Metode',
            'Jumlah (Rp)',
            'Tanggal Transaksi',
            'Catatan/Referensi',
        ];
    }

    /**
     * Memetakan data dari setiap baris.
     * @param Payment $payment
     * @return array
     */
    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->booking_id,
            $payment->booking->user->name ?? 'N/A',
            $payment->booking->vehicle->name ?? 'N/A',
            ucfirst($payment->status), // Paid or Refunded
            ucfirst($payment->method),
            $payment->amount,
            $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '-',
            $payment->reference,
        ];
    }

    /**
     * Mengatur delimiter CSV menjadi titik koma (;).
     * @return array
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
