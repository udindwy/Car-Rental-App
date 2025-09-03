<?php

namespace App\Imports;

use App\Models\VehicleBlackout;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BlackoutsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Setiap row dari Excel akan dikonversi ke model
     */
    public function model(array $row)
    {
        return new VehicleBlackout([
            'vehicle_id'     => $row['id_mobil'], // sesuai heading export
            'start_datetime' => Carbon::createFromFormat('d-m-Y H:i', $row['waktu_mulai']),
            'end_datetime'   => Carbon::createFromFormat('d-m-Y H:i', $row['waktu_selesai']),
            'reason'         => $row['alasan'] ?? null,
        ]);
    }

    /**
     * Validasi kolom
     */
    public function rules(): array
    {
        return [
            'id_mobil'       => 'required|exists:vehicles,id',
            'waktu_mulai'    => 'required|date_format:d-m-Y H:i',
            'waktu_selesai'  => 'required|date_format:d-m-Y H:i|after_or_equal:waktu_mulai',
            'alasan'         => 'nullable|string|max:255',
        ];
    }
}
