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

        if (DB::table('site_pages')->where('slug', 'home')->exists()) {
            return;
        }

        $now = now();

        DB::table('site_pages')->insert([
            'slug' => 'home',
            'title' => 'Inicio',
            'meta_title' => 'Greetik | Desarrollo web profesional',
            'meta_description' => 'Creamos paginas web, ecommerce y aplicaciones a medida para impulsar tu negocio.',
            'body' => null,
            'extra' => json_encode([
                'hero_title' => 'GREETIK Soluciones',
                'hero_subtitle' => 'Desarrollo Web Profesional',
                'hero_text' => 'Creamos paginas web, tiendas online y aplicaciones a medida para impulsar tu negocio.',
                'hero_image' => 'front/img/parallax-slider/images/desarrollo.png',
                'hero_primary_cta_text' => 'Pide presupuesto',
                'hero_primary_cta_url' => '/contacto',
                'hero_secondary_cta_text' => 'Ver portfolio',
                'hero_secondary_cta_url' => '/portfolio',
                'social_proof_title' => 'Resultados que generan confianza',
                'social_proof' => [
                    ['value' => '120+', 'label' => 'Proyectos entregados'],
                    ['value' => '10+', 'label' => 'Anos de experiencia'],
                    ['value' => '24h', 'label' => 'Tiempo medio de respuesta'],
                ],
                'value_props_title' => 'Desarrollo web profesional',
                'value_props' => [
                    [
                        'title' => 'Web corporativa orientada a conversion',
                        'text' => 'Construimos webs rapidas, claras y preparadas para captar oportunidades de negocio.',
                        'image' => 'front/img/1.png',
                    ],
                    [
                        'title' => 'Tiendas online para vender mas',
                        'text' => 'Lanzamos ecommerce con una experiencia de compra fluida y gestion sencilla para tu equipo.',
                        'image' => 'front/img/2.png',
                    ],
                    [
                        'title' => 'Aplicaciones a medida con Laravel',
                        'text' => 'Desarrollamos herramientas internas y plataformas adaptadas a tus procesos reales.',
                        'image' => 'front/img/3.png',
                    ],
                ],
                'process_title' => 'Como trabajamos',
                'process' => [
                    ['title' => '1. Briefing', 'text' => 'Entendemos objetivos, publico y alcance del proyecto.'],
                    ['title' => '2. Propuesta', 'text' => 'Definimos estructura, tecnologia, tiempos y presupuesto.'],
                    ['title' => '3. Desarrollo', 'text' => 'Construimos por fases con revisiones y demos periodicas.'],
                    ['title' => '4. Lanzamiento', 'text' => 'Publicamos, medimos y optimizamos junto a tu equipo.'],
                ],
                'final_cta_title' => 'Hablemos de tu proyecto',
                'final_cta_text' => 'Te ayudamos a convertir ideas en soluciones web rentables.',
                'final_cta_button_text' => 'Contactar ahora',
                'final_cta_button_url' => '/contacto',
            ], JSON_UNESCAPED_UNICODE),
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

        DB::table('site_pages')->where('slug', 'home')->delete();
    }
};
