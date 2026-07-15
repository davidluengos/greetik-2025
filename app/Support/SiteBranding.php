<?php

namespace App\Support;

use App\Models\SitePage;
use Illuminate\Support\Facades\Schema;

final class SiteBranding
{
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
