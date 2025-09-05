<?php

namespace App\Exports;

use App\Models\Coupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class CouponUsageExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        // Ambil semua kupon yang pernah digunakan, beserta relasi booking-nya
        return Coupon::whereHas('bookings')->with('bookings')->get();
    }

    /**
     * Menentukan baris header untuk file CSV.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Kupon',
            'Kode Kupon',
            'Tipe Kupon',
            'Nilai',
            'Total Penggunaan',
            'Total Diskon Diberikan (Rp)',
        ];
    }

    /**
     * Memetakan data dari setiap baris.
     * @param Coupon $coupon
     * @return array
     */
    public function map($coupon): array
    {
        // Hitung total diskon yang diberikan oleh kupon ini
        $totalDiscount = $coupon->bookings->sum('discount_total');

        return [
            $coupon->id,
            $coupon->code,
            ucfirst($coupon->type),
            $coupon->type == 'percent' ? $coupon->value . '%' : $coupon->value,
            $coupon->used_count,
            $totalDiscount,
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
