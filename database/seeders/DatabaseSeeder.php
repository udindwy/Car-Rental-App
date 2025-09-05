<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Extra;
use App\Models\Branch;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Feature;
use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin & Customer
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        User::factory(10)->create(); // 10 customer

        // 2. Buat Data Master Armada
        Branch::factory(3)->create();
        Brand::factory(5)->create();
        Category::factory(4)->create();
        Feature::factory(8)->create();

        // 3. Buat 40 Kendaraan
        Vehicle::factory(40)->create()->each(function ($vehicle) {
            // Pasangkan setiap mobil dengan 1-5 fitur secara acak
            $features = Feature::inRandomOrder()->limit(rand(1, 5))->get();
            $vehicle->features()->attach($features);
        });

        // 4. Buat 50 Pemesanan Acak
        Booking::factory(50)->create();

        // 5. TAMBAHKAN BARIS INI
        Review::factory(30)->create();

        // 5. Panggil Factory Baru
        Payment::factory(40)->create();
        Coupon::factory(10)->create();
        Extra::factory(4)->create();
    }
}
