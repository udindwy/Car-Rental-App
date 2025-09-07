<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\VehicleImage;

class VehicleImageSeeder extends Seeder
{
    public function run(): void
    {
        $defaultImage = 'vehicles/default.jpg';

        foreach (Vehicle::all() as $vehicle) {
            if ($vehicle->images()->count() === 0) {
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'path' => $defaultImage,
                ]);
            }
        }
    }
}
