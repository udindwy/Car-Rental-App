<?php

namespace App\Exports;

use App\Models\VehicleBlackout;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BlackoutsExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return VehicleBlackout::with('vehicle')->get();
    }

    public function headings(): array
    {
        return [
            'ID Blackout',
            'ID Mobil',
            'Nama Mobil',
            'Waktu Mulai',
            'Waktu Selesai',
            'Alasan',
        ];
    }

    public function map($blackout): array
    {
        return [
            $blackout->id,
            $blackout->vehicle->id,
            $blackout->vehicle->name,
            $blackout->start_datetime->format('d-m-Y H:i'),
            $blackout->end_datetime->format('d-m-Y H:i'),
            $blackout->reason ?? '-',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F81BD']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
