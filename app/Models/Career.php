<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'name',
        'email',
        'position',
        'cv',
        'ip_address',
        'country',
        'city',
        'region',
        'zip_code',
        'latitude',
        'longitude',
        'user_agent',
        'referrer'
    ];
}
