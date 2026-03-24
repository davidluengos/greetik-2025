<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('excerpt')->nullable();
                $table->longText('body')->nullable();
                $table->string('icon')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true)->index();
                $table->unsignedInteger('menu_order')->default(0)->index();
                $table->timestamp('published_at')->nullable()->index();
                $table->json('extra')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
