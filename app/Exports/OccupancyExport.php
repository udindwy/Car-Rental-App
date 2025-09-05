<?php

namespace App\Exports;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class OccupancyExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    public function collection(): Collection
    {
        $vehicles = Vehicle::where('status', 'active')->get();
        $reportData = new Collection();

        $periodInDays = 30;
        $startDate = now()->subDays($periodInDays - 1)->startOfDay();
        $endDate = now()->endOfDay();

        foreach ($vehicles as $vehicle) {
            $bookedDays = 0;
            $bookings = $vehicle->bookings()
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('pickup_datetime', '<=', $endDate)
                        ->where('dropoff_datetime', '>=', $startDate);
                })
                ->whereIn('status', ['confirmed', 'on_rent', 'completed'])
                ->get();

            foreach ($bookings as $booking) {
                // PERBAIKAN DI DUA BARIS INI
                $bookingStart = $booking->pickup_datetime->max($startDate);
                $bookingEnd = $booking->dropoff_datetime->min($endDate);

                // Pastikan bookingEnd tidak lebih awal dari bookingStart
                if ($bookingEnd->greaterThanOrEqualTo($bookingStart)) {
                    $bookedDays += $bookingStart->diffInDays($bookingEnd) + 1;
                }
            }

            $occupancyRate = ($periodInDays > 0) ? ($bookedDays / $periodInDays) * 100 : 0;

            $reportData->push([
                'id' => $vehicle->id,
                'name' => $vehicle->name,
                'booked_days' => $bookedDays,
                'occupancy_rate' => round($occupancyRate, 2)
            ]);
        }

        return $reportData;
    }

    public function headings(): array
    {
        return [
            'ID Mobil',
            'Nama Mobil',
            'Total Hari Disewa (30 Hari Terakhir)',
            'Tingkat Okupansi (%)',
        ];
    }

    public function map($row): array
    {
        return [
            $row['id'],
            $row['name'],
            $row['booked_days'],
            $row['occupancy_rate'],
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
