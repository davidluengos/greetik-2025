<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $builder): void {
                $builder->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Etiquetas de categoria separadas por comas (sin slug).
     *
     * @return list<string>
     */
    public function categoryTokens(): array
    {
        if (blank($this->category)) {
            return [];
        }

        return collect(explode(',', (string) $this->category))
            ->map(static fn (string $token): string => trim($token))
            ->filter(static fn (string $token): bool => $token !== '')
            ->values()
            ->all();
    }

    /**
     * Slugs de filtro para mixitup (una entrada por etiqueta).
     *
     * @return list<string>
     */
    public function categorySlugs(): array
    {
        $tokens = $this->categoryTokens();
        if ($tokens === []) {
            return ['general'];
        }

        return collect($tokens)
            ->map(static fn (string $token): string => Str::slug($token))
            ->unique()
            ->values()
            ->all();
    }

    /** Texto legible para mostrar en detalle (ej. "web, app"). */
    public function categoryDisplay(): ?string
    {
        $tokens = $this->categoryTokens();

        return $tokens === [] ? null : implode(', ', $tokens);
    }
}
