<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automation_assessments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Respuestas del wizard
            $table->string('sector')->nullable();
            $table->string('sector_other')->nullable();
            $table->string('company_size')->nullable();
            $table->json('tools')->nullable();
            $table->string('repetitive_hours')->nullable();
            $table->string('customer_management')->nullable();
            $table->string('quotations')->nullable();
            $table->string('follow_up')->nullable();
            $table->json('documents')->nullable();
            $table->json('communication')->nullable();
            $table->text('main_problem')->nullable();
            $table->string('hourly_cost')->nullable();

            // Resultados del motor de calculo
            $table->unsignedTinyInteger('score')->default(0);
            $table->string('score_level')->nullable();
            $table->unsignedSmallInteger('estimated_hours_saved')->default(0);
            $table->unsignedInteger('estimated_annual_saving')->default(0);
            $table->string('recommended_solution_key')->nullable();
            $table->unsignedInteger('estimated_investment_min')->default(0);
            $table->unsignedInteger('estimated_investment_max')->default(0);
            $table->json('recommendations')->nullable();
            $table->json('meta')->nullable();

            // Lead opcional
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('privacy_accepted')->default(false);
            $table->timestamp('contacted_at')->nullable()->index();

            // Contexto tecnico
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();

            $table->timestamps();
            $table->index(['sector', 'created_at']);
            $table->index('score_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_assessments');
    }
};
