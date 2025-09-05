<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $booking = Booking::inRandomOrder()->first();

        return [
            'booking_id' => $booking->id,
            'amount' => $booking->grand_total,
            'method' => $this->faker->randomElement(['cash', 'transfer']),
            'status' => 'paid',
            'paid_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'reference' => 'Pembayaran Lunas',
        ];
    }
}
