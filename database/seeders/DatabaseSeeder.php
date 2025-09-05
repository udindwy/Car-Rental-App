<?php

namespace Database\Seeders;

// Pastikan semua model yang digunakan sudah di-import
use App\Models\User;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\Extra;
use App\Models\Page;
use App\Models\Setting;
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
        User::factory(10)->create();

        // 2. Buat Data Master Armada
        Branch::factory(3)->create();
        Brand::factory(5)->create();
        Category::factory(4)->create();
        Feature::factory(8)->create();

        // 3. Buat Kendaraan
        Vehicle::factory(40)->create()->each(function ($vehicle) {
            $features = Feature::inRandomOrder()->limit(rand(1, 5))->get();
            $vehicle->features()->attach($features);
        });

        // 4. Buat Data Transaksional
        Booking::factory(50)->create();
        Review::factory(30)->create();
        Payment::factory(40)->create();
        Coupon::factory(10)->create();

        // 5. Buat Layanan Tambahan secara eksplisit
        Extra::create(['name' => 'Supir Profesional', 'type' => 'per_day', 'price' => 150000]);
        Extra::create(['name' => 'Kursi Bayi (Child Seat)', 'type' => 'per_day', 'price' => 50000]);
        Extra::create(['name' => 'Asuransi Perjalanan Penuh', 'type' => 'per_booking', 'price' => 100000]);
        Extra::create(['name' => 'Biaya Antar/Jemput Bandara', 'type' => 'per_booking', 'price' => 75000]);

        // 6. Buat Halaman Statis (PERBAIKAN DI SINI)
        Page::create([
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' => 'Ini adalah halaman tentang kami...',
            'published' => true,
        ]);
        Page::create([
            'title' => 'Syarat & Ketentuan',
            'slug' => 'syarat-ketentuan',
            'content' => 'Ini adalah halaman syarat dan ketentuan...',
            'published' => true,
        ]);
        Page::factory(3)->create();

        // 7. Buat Pengaturan Situs
        Setting::create([
            'site_name' => 'Car Rental',
            'whatsapp' => '6281234567890',
            'email' => 'kontak@rentalkeren.com',
            'address' => 'Jl. Malioboro No. 1, Yogyakarta',
        ]);
    }
}