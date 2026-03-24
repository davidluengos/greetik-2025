<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'website_url',
        'is_active',
        'menu_order',
        'published_at',
        'extra',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'menu_order' => 'integer',
            'published_at' => 'datetime',
            'extra' => 'array',
        ];
    }
}
