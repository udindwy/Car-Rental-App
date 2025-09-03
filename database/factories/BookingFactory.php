<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil user, vehicle, dan branch secara acak yang sudah ada
        $user = User::where('role', 'customer')->inRandomOrder()->first();
        $vehicle = Vehicle::inRandomOrder()->first();
        $branch = Branch::inRandomOrder()->first();

        // Generate tanggal acak
        $pickupDate = $this->faker->dateTimeBetween('-30 days', '+10 days');
        $duration = $this->faker->numberBetween(1, 7);
        $dropoffDate = (clone $pickupDate)->modify("+$duration days");

        // Hitung total harga sederhana
        $basePrice = $vehicle->base_price_day;
        $grandTotal = $basePrice * $duration;

        return [
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'branch_pickup_id' => $branch->id,
            'branch_dropoff_id' => $branch->id, // Dibuat sama untuk simple
            'pickup_datetime' => $pickupDate,
            'dropoff_datetime' => $dropoffDate,
            'duration_days' => $duration,
            'subtotal' => $grandTotal,
            'grand_total' => $grandTotal,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'on_rent', 'completed', 'cancelled']),
            'notes' => $this->faker->sentence,
        ];
    }
}
