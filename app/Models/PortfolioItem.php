<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $table = 'portfolio_items';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'category',
        'client',
        'completed_at',
        'is_active',
        'menu_order',
        'published_at',
        'extra',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'date',
            'is_active' => 'boolean',
            'menu_order' => 'integer',
            'published_at' => 'datetime',
            'extra' => 'array',
        ];
    }
}
