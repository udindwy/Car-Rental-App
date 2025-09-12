<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Ambil satu booking acak yang BELUM memiliki ulasan.
        $booking = Booking::doesntHave('review')->inRandomOrder()->first();

        // 2. Jika tidak ada lagi booking yang bisa diulas, hentikan proses.
        if (!$booking) {
            return [];
        }

        // 3. Gunakan data dari booking tersebut agar konsisten.
        return [
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id, // Mengambil user yang melakukan booking.
            'vehicle_id' => $booking->vehicle_id, // Mengambil mobil yang di-booking.
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->realText(150),
            'approved' => $this->faker->boolean(70),
        ];
    }
}