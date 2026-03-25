<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{
    /** Slugs de paginas legales (URLs de primer nivel, p. ej. /aviso-legal). */
    public static function legalSlugs(): array
    {
        return [
            'aviso-legal',
            'politica-de-privacidad',
            'politica-de-cookies',
            'terminos-y-condiciones',
        ];
    }

    public function publicUrl(): ?string
    {
        return match ($this->slug) {
            'sobre-nosotros' => route('about'),
            'contacto' => route('contacto'),
            'portfolio' => route('portfolio.index'),
            default => in_array($this->slug, self::legalSlugs(), true)
                ? route('legal.page', ['slug' => $this->slug])
                : null,
        };
    }

    protected $fillable = [
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'body',
        'extra',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
