<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'image',
        'badge',
        'is_active',
        'menu_order',
        'extra',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'menu_order' => 'integer',
            'extra' => 'array',
        ];
    }
}
