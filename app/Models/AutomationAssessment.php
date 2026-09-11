<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AutomationAssessment extends Model
{
    protected $fillable = [
        'uuid',
        'sector',
        'sector_other',
        'company_size',
        'tools',
        'repetitive_hours',
        'customer_management',
        'quotations',
        'follow_up',
        'documents',
        'communication',
        'main_problem',
        'hourly_cost',
        'score',
        'score_level',
        'estimated_hours_saved',
        'estimated_annual_saving',
        'recommended_solution_key',
        'estimated_investment_min',
        'estimated_investment_max',
        'recommendations',
        'meta',
        'name',
        'email',
        'company',
        'phone',
        'privacy_accepted',
        'contacted_at',
        'ip',
        'user_agent',
        'referrer',
    ];

    protected function casts(): array
    {
        return [
            'tools' => 'array',
            'documents' => 'array',
            'communication' => 'array',
            'recommendations' => 'array',
            'meta' => 'array',
            'privacy_accepted' => 'boolean',
            'contacted_at' => 'datetime',
            'score' => 'integer',
            'estimated_hours_saved' => 'integer',
            'estimated_annual_saving' => 'integer',
            'estimated_investment_min' => 'integer',
            'estimated_investment_max' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(static function (self $assessment): void {
            if (empty($assessment->uuid)) {
                $assessment->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function hasLead(): bool
    {
        return ! empty($this->email);
    }
}
