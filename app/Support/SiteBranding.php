<?php

namespace App\Support;

use App\Models\SitePage;
use Illuminate\Support\Facades\Schema;

final class SiteBranding
{
    public static function siteName(): string
    {
        $name = trim((string) config('app.name', 'Greetik'));

        return $name !== '' && strcasecmp($name, 'Laravel') !== 0
            ? $name
            : 'Greetik';
    }

    /**
     * Titulo de pestaña unificado: meta SEO si existe, si no "{pagina} | {marca}".
     */
    public static function pageTitle(?string $pageTitle = null, ?string $metaTitle = null): string
    {
        $meta = trim((string) $metaTitle);
        if ($meta !== '') {
            return $meta;
        }

        $brand = self::siteName();
        $page = trim((string) $pageTitle);

        if ($page === '') {
            return $brand;
        }

        return $page.' | '.$brand;
    }

    public static function faviconUrl(): string
    {
        $default = asset('front/img/favicon.png');

        if (! Schema::hasTable('site_pages')) {
            return $default;
        }

        $home = SitePage::query()->where('slug', 'home')->first();
        $extra = is_array($home?->extra) ? $home->extra : [];
        $path = trim((string) ($extra['site_favicon'] ?? ''));

        if ($path === '') {
            return $default;
        }

        return asset($path);
    }
}
