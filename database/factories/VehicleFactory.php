<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Branch;
use App\Models\Feature;
use App\Models\Category;
use App\Models\Extra;      
use App\Models\Vehicle;    
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        // (Logika definisi Anda yang sudah bagus tetap dipertahankan)
        $brandName = Brand::inRandomOrder()->first()->name ?? $this->faker->company;
        $modelName = $this->faker->randomElement(['Avanza', 'Xpander', 'Brio', 'Innova', 'Pajero', 'CRV', 'Fortuner']);
        $name = "$brandName $modelName " . $this->faker->word();

        return [
            'branch_id' => Branch::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,

            'name' => $name,
            'slug' => Str::slug($name) . '-' . uniqid(),
            'transmission' => $this->faker->randomElement(['AT', 'MT']),
            'fuel' => $this->faker->randomElement(['bensin', 'diesel']),
            'seats' => $this->faker->randomElement([4, 5, 7, 8]),
            'base_price_day' => $this->faker->randomElement([250000, 350000, 450000, 600000, 750000]),
            'description' => $this->faker->paragraph,
            'status' => 'active',
        ];
    }

    /**
     * Konfigurasi factory untuk menambahkan relasi setelah model dibuat.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Vehicle $vehicle) {
            // --- Logika untuk Extras ---
            $extras = Extra::all()->pluck('id');
            if ($extras->isNotEmpty() && fake()->boolean(70)) {
                $extrasToAttach = $extras->random(fake()->numberBetween(1, min(3, $extras->count())));
                $vehicle->extras()->attach($extrasToAttach);
            }

            // --- Logika untuk Features (dipindahkan dari seeder) ---
            $features = Feature::all()->pluck('id');
            if ($features->isNotEmpty()) {
                $featuresToAttach = $features->random(fake()->numberBetween(2, min(5, $features->count())));
                $vehicle->features()->attach($featuresToAttach);
            }
        });
    }
}
