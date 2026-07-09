<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'author',
        'role',
        'quote',
        'photo',
        'is_active',
        'menu_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'menu_order' => 'integer',
        ];
    }
}
