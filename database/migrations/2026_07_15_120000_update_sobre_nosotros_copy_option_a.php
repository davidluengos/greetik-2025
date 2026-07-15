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

        $body = <<<'HTML'
<p>En <strong>Greetik Soluciones</strong> desarrollamos software y aplicaciones web a medida desde Cáceres para empresas de toda España y Latinoamérica. Trabajamos con pymes y organizaciones que necesitan herramientas digitales fiables: webs, intranets, ecommerce y sistemas que encajan con su forma de trabajar, no con plantillas genéricas.</p>
<p>Somos un equipo pequeño y cercano. Eso nos permite implicarnos en cada proyecto, hablar contigo sin intermediarios y acompañarte cuando el software tiene que evolucionar con tu negocio.</p>
HTML;

        DB::table('site_pages')
            ->where('slug', 'sobre-nosotros')
            ->update([
                'body' => $body,
                'meta_description' => 'Greetik Soluciones: desarrollo de software y aplicaciones web a medida desde Cáceres. Proyectos para empresas en España y Latinoamérica.',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Sin reversión: el contenido anterior era variable (CMS / migraciones previas).
    }
};
