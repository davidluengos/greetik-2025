<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('product_forms')) {
            Schema::create('product_forms', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title');
                $table->text('intro')->nullable();
                $table->string('action_url')->default('/contacto');
                $table->string('button_label')->default('Enviar');
                $table->json('fields')->nullable();
                $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_forms');
    }
};
