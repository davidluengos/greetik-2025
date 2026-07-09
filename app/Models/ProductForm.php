<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductForm extends Model
{
    protected $fillable = [
        'name',
        'title',
        'intro',
        'action_url',
        'button_label',
        'fields',
        'is_active',
        'autoresponse_enabled',
        'autoresponse_subject',
        'autoresponse_body',
        'autoresponse_from_name',
        'autoresponse_from_email',
        'autoresponse_reply_to',
    ];

    protected function casts(): array
    {
        return [
            'fields' => 'array',
            'is_active' => 'boolean',
            'autoresponse_enabled' => 'boolean',
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'product_form_id');
    }
}
