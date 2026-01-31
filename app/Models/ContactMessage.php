<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';
    protected $fillable = [
        'type', 'name', 'email', 'company', 'message',
        'ip_address', 'country', 'city', 'region', 'zip_code',
        'latitude', 'longitude', 'user_agent', 'referrer'
    ];
}
