<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingTable extends Model
{
    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'plans',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'plans' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'pricing_table_id');
    }
}
