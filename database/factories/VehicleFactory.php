<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Membuat nama mobil acak yang lebih realistis
        $brandName = Brand::inRandomOrder()->first()->name ?? $this->faker->company;
        $modelName = $this->faker->randomElement(['Avanza', 'Xpander', 'Brio', 'Innova', 'Pajero', 'CRV', 'Fortuner']);
        $name = "$brandName $modelName " . $this->faker->word();

        return [
            // Mengambil ID secara acak dari tabel yang sudah terisi
            'branch_id' => Branch::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            
            'name' => $name,
            'slug' => Str::slug($name) . '-' . uniqid(), // Menjamin slug unik
            'transmission' => $this->faker->randomElement(['AT', 'MT']),
            'fuel' => $this->faker->randomElement(['bensin', 'diesel']),
            'seats' => $this->faker->randomElement([4, 5, 7, 8]),
            'base_price_day' => $this->faker->randomElement([250000, 350000, 450000, 600000, 750000]),
            'description' => $this->faker->paragraph,
            'status' => 'active',
        ];
    }
}
