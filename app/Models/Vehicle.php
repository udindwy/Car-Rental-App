<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'brand_id',
        'category_id',
        'name',
        'slug',
        'transmission',
        'seats',
        'fuel',
        'base_price_day',
        'description',
        'status',
    ];

    // --- Relasi ---
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_vehicle');
    }

    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class);
    }

    public function blackouts()
    {
        return $this->hasMany(VehicleBlackout::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Accessor untuk menghitung rata-rata rating.
     * Akan tersedia sebagai properti $vehicle->average_rating
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
    
    public function extras()
    {
        return $this->belongsToMany(Extra::class);
    }
}
