<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['percent', 'flat']);
        $value = ($type == 'percent') ? $this->faker->numberBetween(10, 25) : $this->faker->randomElement([50000, 100000]);

        return [
            'code' => Str::upper(Str::random(8)),
            'type' => $type,
            'value' => $value,
            'min_total' => $this->faker->randomElement([null, 300000, 500000]),
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(20),
            'max_usage' => $this->faker->numberBetween(50, 100),
            'status' => 'active',
        ];
    }
}
