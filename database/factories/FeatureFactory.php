<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Air Conditioner',
                'Bluetooth',
                'USB Port',
                'GPS Navigation',
                'Child Seat',
                'Leather Seats',
                'Sunroof',
                'Parking Sensors',
                'Rear Camera',
                'Keyless Entry'
            ]),
        ];
    }
}
