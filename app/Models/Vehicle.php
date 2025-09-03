<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'brand_id',
        'category_id',
        'name',
        'slug',
        'transmission',
        'seats',
        'doors',
        'luggage',
        'fuel',
        'year',
        'plate_number',
        'base_price_day',
        'description',
        'status',
    ];

    // --- Definisikan relasi yang sudah ada ---
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
        return $this->belongsToMany(Feature::class);
    }

    // --- TAMBAHKAN METHOD RELASI BARU INI ---
    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class);
    }
}
