<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'product_form_id',
        'pricing_table_id',
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

    public function productForm(): BelongsTo
    {
        return $this->belongsTo(ProductForm::class);
    }

    public function pricingTable(): BelongsTo
    {
        return $this->belongsTo(PricingTable::class);
    }
}
