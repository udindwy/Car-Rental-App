<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi many-to-many ke Vehicle.
     */
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
