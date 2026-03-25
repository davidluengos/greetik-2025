<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('site_pages')) {
            Schema::create('site_pages', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title');
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->longText('body')->nullable();
                $table->json('extra')->nullable();
                $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('site_pages')) {
            $count = DB::table('site_pages')->whereIn('slug', ['sobre-nosotros', 'contacto'])->count();
            if ($count < 2) {
                $now = now();
                DB::table('site_pages')->insertOrIgnore([
                    [
                        'slug' => 'sobre-nosotros',
                        'title' => 'Sobre nosotros',
                        'meta_title' => 'Sobre nosotros | Greetik',
                        'meta_description' => 'Conoce Greetik y nuestro equipo.',
                        'body' => '<p>Greetik ayuda a empresas y profesionales a crecer en el entorno digital con soluciones personalizadas.</p><ul class="list-unstyled"><li><i class="fa fa-angle-right pr-10"></i> Desarrollo web y aplicaciones</li><li><i class="fa fa-angle-right pr-10"></i> Diseno y experiencia de usuario</li><li><i class="fa fa-angle-right pr-10"></i> Mantenimiento y soporte</li></ul><blockquote><p>Cada proyecto es una oportunidad de construir algo util y duradero.</p><small>Greetik</small></blockquote>',
                        'extra' => json_encode([
                            'hero_image' => 'front/img/service3.jpg',
                            'carousel' => [
                                ['image' => 'front/img/service3.jpg', 'caption' => 'Proyectos a medida'],
                                ['image' => 'front/img/service2.jpg', 'caption' => 'Equipo cercano'],
                                ['image' => 'front/img/service5.jpg', 'caption' => 'Tecnologia moderna'],
                            ],
                        ], JSON_UNESCAPED_UNICODE),
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'slug' => 'contacto',
                        'title' => 'Contacto',
                        'meta_title' => 'Contacto | Greetik',
                        'meta_description' => 'Contacta con Greetik.',
                        'body' => '<p>Cuéntanos tu idea y te responderemos lo antes posible.</p>',
                        'extra' => json_encode([
                            'address_title' => 'Direccion',
                            'address' => "Greetik\nTu ciudad, Pais",
                            'hours_title' => 'Horario',
                            'hours' => "Lunes - Viernes 9:00 - 18:00\nSabado - Cerrado\nDomingo - Cerrado",
                            'phones_title' => 'Telefono',
                            'phones' => ['+34 000 000 000'],
                            'form_heading' => 'Envianos un mensaje',
                            'map_embed' => '',
                            'product_form_id' => null,
                        ], JSON_UNESCAPED_UNICODE),
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_pages');
    }
};
