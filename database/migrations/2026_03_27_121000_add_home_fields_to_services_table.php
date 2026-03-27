<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'home_short_text')) {
                $table->string('home_short_text', 255)->nullable()->after('show_on_home');
            }

            if (!Schema::hasColumn('services', 'home_order')) {
                $table->unsignedInteger('home_order')->default(0)->after('home_short_text')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'home_order')) {
                $table->dropColumn('home_order');
            }

            if (Schema::hasColumn('services', 'home_short_text')) {
                $table->dropColumn('home_short_text');
            }
        });
    }
};
