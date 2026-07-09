<?php

use App\Support\Home\DefaultValueProps;
use App\Support\Home\HomeSections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_pages')) {
            return;
        }

        $row = DB::table('site_pages')->where('slug', 'home')->first();
        if ($row === null) {
            return;
        }

        $extra = json_decode((string) $row->extra, true);
        $extra = is_array($extra) ? $extra : [];

        // Orden/activación por defecto de los módulos.
        $extra['home_sections'] = HomeSections::defaults();

        // Textos de los módulos nuevos.
        $extra['featured_products_label'] = $extra['featured_products_label'] ?? 'Producto destacado';
        $extra['testimonials_title'] = $extra['testimonials_title'] ?? 'Opiniones de clientes';

        // Ventajas de una web (copy definitiva).
        $extra['value_props_title'] = DefaultValueProps::TITLE;
        $extra['value_props'] = DefaultValueProps::get();

        DB::table('site_pages')
            ->where('slug', 'home')
            ->update([
                'extra' => json_encode($extra, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_pages')) {
            return;
        }

        $row = DB::table('site_pages')->where('slug', 'home')->first();
        if ($row === null) {
            return;
        }

        $extra = json_decode((string) $row->extra, true);
        $extra = is_array($extra) ? $extra : [];

        unset(
            $extra['home_sections'],
            $extra['featured_products_label'],
            $extra['testimonials_title'],
        );

        DB::table('site_pages')
            ->where('slug', 'home')
            ->update([
                'extra' => json_encode($extra, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
            ]);
    }
};
