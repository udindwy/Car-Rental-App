<?php

namespace Database\Seeders;

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

        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer', 
        ]);

        // Buat 10 customer acak lainnya
        User::factory(10)->create();

        // 2. Buat Data Master Armada
        Branch::factory(3)->create();
        Brand::factory(5)->create();
        Category::factory(4)->create();
        Feature::factory(8)->create();

        Extra::create(['name' => 'Supir Profesional', 'type' => 'per_day', 'price' => 300000]);
        Extra::create(['name' => 'GPS Navigasi', 'type' => 'per_booking', 'price' => 50000]);
        Extra::create(['name' => 'Baby Car Seat', 'type' => 'per_booking', 'price' => 75000]);
        Extra::create(['name' => 'Asuransi Penuh', 'type' => 'per_day', 'price' => 150000]);

        // 3. Buat Kendaraan
        Vehicle::factory(40)->create();

        // 4. Buat Data Transaksional
        Booking::factory(50)->create();
        Review::factory(30)->create();
        Payment::factory(40)->create();
        Coupon::factory(10)->create();

        // 5. Buat Halaman Statis
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

        // 6. Buat Pengaturan Situs Awal (SESUAI MIGRASI ANDA)
        Setting::create([
            'site_name' => 'Car Rental',
            'whatsapp' => '6281234567890',
            'email' => 'kontak@carrental.com',
        'address' => 'Jl. Malioboro No. 1, Yogyakarta',
            'phone' => '0274123456',
        ]);
    }
}
