<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'product_form_id')) {
                $table->foreignId('product_form_id')
                    ->nullable()
                    ->after('extra')
                    ->constrained('product_forms')
                    ->nullOnDelete();
            }
            if (!Schema::hasColumn('projects', 'pricing_table_id')) {
                $table->foreignId('pricing_table_id')
                    ->nullable()
                    ->after('product_form_id')
                    ->constrained('pricing_tables')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['product_form_id']);
            $table->dropForeign(['pricing_table_id']);
            $table->dropColumn(['product_form_id', 'pricing_table_id']);
        });
    }
};
