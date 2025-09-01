<?php

namespace App\Models;

use App\Models\VehicleImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'doors',
        'luggage',
        'fuel',
        'year',
        'plate_number',
        'base_price_day',
        'description',
        'status',
    ];

    // --- Definisikan relasi agar mudah diakses ---
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
}
