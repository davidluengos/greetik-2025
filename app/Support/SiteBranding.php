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

    /**
     * Meta description por defecto (fallback global si la vista no la sobrescribe).
     * Editable desde site_pages.home.extra.site_description.
     */
    public static function defaultDescription(): string
    {
        $default = 'Greetik Soluciones — Desarrollo de software a medida, aplicaciones web, tiendas online y consultoría TIC.';

        if (! Schema::hasTable('site_pages')) {
            return $default;
        }

        $home = SitePage::query()->where('slug', 'home')->first();
        $extra = is_array($home?->extra) ? $home->extra : [];
        $desc = trim((string) ($extra['site_description'] ?? ''));

        return $desc !== '' ? $desc : $default;
    }

    /**
     * Imagen por defecto para Open Graph / Twitter Card (URL absoluta).
     * Editable desde site_pages.home.extra.site_og_image.
     */
    public static function defaultOgImage(): string
    {
        $default = asset('front/img/parallax-slider/images/greetik-soluciones.png');

        if (! Schema::hasTable('site_pages')) {
            return $default;
        }

        $home = SitePage::query()->where('slug', 'home')->first();
        $extra = is_array($home?->extra) ? $home->extra : [];
        $path = trim((string) ($extra['site_og_image'] ?? ''));

        return $path !== '' ? asset($path) : $default;
    }
}
