<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'type',
        'start_date',
        'end_date',
        'min_days',
        'percent_adjustment',
    ];

    // Di dalam class Vehicle
    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class);
    }
}
