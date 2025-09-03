<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'branch_pickup_id',
        'branch_dropoff_id',
        'pickup_datetime',
        'dropoff_datetime',
        'duration_days',
        'subtotal',
        'extras_total',
        'discount_total',
        'tax_total',
        'grand_total',
        'coupon_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'pickup_datetime' => 'datetime',
        'dropoff_datetime' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
}
