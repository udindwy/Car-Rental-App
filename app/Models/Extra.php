<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class)->withPivot('qty', 'price', 'total');
    }
}
