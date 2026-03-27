<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'icon',
        'image',
        'is_active',
        'show_on_home',
        'home_short_text',
        'home_order',
        'menu_order',
        'published_at',
        'extra',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_on_home' => 'boolean',
            'home_order' => 'integer',
            'menu_order' => 'integer',
            'published_at' => 'datetime',
            'extra' => 'array',
        ];
    }
}
