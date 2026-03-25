<?php

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

        if (DB::table('site_pages')->where('slug', 'portfolio')->exists()) {
            return;
        }

        $now = now();

        DB::table('site_pages')->insert([
            'slug' => 'portfolio',
            'title' => 'Portfolio',
            'meta_title' => 'Portfolio | Greetik',
            'meta_description' => 'Proyectos y trabajos seleccionados de Greetik.',
            'body' => '<p class="lead">Estos son algunos de los proyectos en los que hemos trabajado. Cada pieza refleja un reto distinto: desde webs corporativas hasta aplicaciones a medida.</p><p>Utiliza los filtros para explorar por tipo de trabajo.</p>',
            'extra' => null,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_pages')) {
            return;
        }

        DB::table('site_pages')->where('slug', 'portfolio')->delete();
    }
};
