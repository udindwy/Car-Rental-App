<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_id',
        'start_date',
        'end_date',
        'reason',
    ];

    /**
     * Get the vehicle that owns the availability.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
