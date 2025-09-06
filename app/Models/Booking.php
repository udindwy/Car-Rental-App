<?php

namespace App\Models;

use App\Mail\BookingStatusChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pickup_datetime' => 'datetime',
        'dropoff_datetime' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     * Di sinilah kita akan menangani semua event secara langsung.
     */
    protected static function booted(): void
    {
        // Event untuk booking yang BARU DIBUAT
        static::created(function (Booking $booking) {
            try {
                // Pastikan relasi user dimuat dan memiliki email
                $booking->load('user');
                if ($booking->user && $booking->user->email) {
                    Mail::to($booking->user->email)->send(new BookingStatusChanged($booking));
                }
            } catch (\Exception $e) {
                // Catat error jika pengiriman email gagal
                Log::error('Gagal mengirim email (booking baru) dari Model: ' . $e->getMessage());
            }
        });

        // Event untuk booking yang DIUBAH
        static::updating(function (Booking $booking) {
            // Hanya kirim email jika kolom 'status' yang berubah
            if ($booking->isDirty('status')) {
                try {
                    // Pastikan relasi user dimuat dan memiliki email
                    $booking->load('user');
                    if ($booking->user && $booking->user->email) {
                        Mail::to($booking->user->email)->send(new BookingStatusChanged($booking));
                    }
                } catch (\Exception $e) {
                    // Catat error jika pengiriman email gagal
                    Log::error('GAGAL mengirim email (update status) dari Model: ' . $e->getMessage());
                }
            }
        });
    }


    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vehicle for the booking.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the pickup branch for the booking.
     */
    public function pickupBranch()
    {
        return $this->belongsTo(Branch::class, 'branch_pickup_id');
    }

    /**
     * Get the dropoff branch for the booking.
     */
    public function dropoffBranch()
    {
        return $this->belongsTo(Branch::class, 'branch_dropoff_id');
    }

    /**
     * Get the payments for the booking.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the extras for the booking.
     */
    public function extras()
    {
        return $this->belongsToMany(Extra::class)->withPivot('qty', 'price', 'total');
    }

    /**
     * Get the coupon associated with the booking.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
