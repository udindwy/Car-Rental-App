<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'logo',
        'theme_color',
        'whatsapp',
        'phone',
        'email',
        'address',
        'facebook_url',
        'instagram_url',
    ];
}
