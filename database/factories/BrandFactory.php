<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    public function definition(): array
    {
        $brand = $this->faker->unique()->randomElement(['Toyota', 'Honda', 'Suzuki', 'Daihatsu', 'Mitsubishi', 'Nissan', 'Hyundai']);
        return [
            'name' => $brand,
            'slug' => Str::slug($brand),
        ];
    }
}
