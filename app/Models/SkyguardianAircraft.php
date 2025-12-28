<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkyguardianAircraft extends Model
{
    protected $casts = [
        'metadata' => 'array',
        'is_military' => 'boolean',
        'is_drone' => 'boolean',
        'is_nato' => 'boolean',
        'is_friendly' => 'boolean',
        'is_potential_threat' => 'boolean',
    ];

    public function positions(): HasMany
    {
        return $this->hasMany(SkyGuardianPositions::class, 'aircraft_id');
    }

    public function flights(): HasMany
    {
        return $this->hasMany(SkyguardianFlights::class, 'aircraft_id');
    }
}
