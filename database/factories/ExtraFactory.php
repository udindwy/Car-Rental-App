<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Gunakan unique() untuk mencegah error duplikasi saat seeding
        $name = $this->faker->unique()->randomElement(['Supir Profesional', 'Kursi Bayi (Child Seat)', 'Asuransi Perjalanan Penuh', 'Biaya Antar/Jemput Bandara']);
        $type = ($name == 'Supir Profesional' || $name == 'Kursi Bayi (Child Seat)') ? 'per_day' : 'per_booking';
        $price = $this->faker->randomElement([50000, 100000, 150000, 200000]);

        return [
            'name' => $name,
            'type' => $type,
            'price' => $price,
        ];
    }
}
