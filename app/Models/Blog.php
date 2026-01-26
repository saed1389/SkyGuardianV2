<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title_en', 'title_tr', 'title_ee',
        'slug_en', 'slug_tr', 'slug_ee',
        'excerpt_en', 'excerpt_tr', 'excerpt_ee',
        'body_en', 'body_tr', 'body_ee',
        'category_en', 'category_tr', 'category_ee',
        'image', 'published_at', 'status', 'resource'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];

    // Helper to format date nicely
    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : '';
    }
}
