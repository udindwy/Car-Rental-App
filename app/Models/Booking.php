<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
