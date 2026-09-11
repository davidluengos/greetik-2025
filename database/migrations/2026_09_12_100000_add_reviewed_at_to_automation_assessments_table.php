<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('automation_assessments', function (Blueprint $table) {
            $table->timestamp('reviewed_at')->nullable()->after('contacted_at')->index();
        });
    }

    public function down(): void
    {
        Schema::table('automation_assessments', function (Blueprint $table) {
            $table->dropIndex(['reviewed_at']);
            $table->dropColumn('reviewed_at');
        });
    }
};
