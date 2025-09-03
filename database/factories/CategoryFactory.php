<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Menggunakan unique() untuk memastikan tidak ada kategori yang sama
        $category = $this->faker->unique()->randomElement(['MPV', 'SUV', 'Sedan', 'City Car', 'LCGC', 'Hatchback', 'Commercial']);

        return [
            'name' => $category,
            'slug' => Str::slug($category),
        ];
    }
}
