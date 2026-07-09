<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_forms', function (Blueprint $table) {
            $table->boolean('autoresponse_enabled')->default(false)->after('is_active');
            $table->string('autoresponse_subject')->nullable()->after('autoresponse_enabled');
            $table->longText('autoresponse_body')->nullable()->after('autoresponse_subject');
            $table->string('autoresponse_from_name')->nullable()->after('autoresponse_body');
            $table->string('autoresponse_from_email')->nullable()->after('autoresponse_from_name');
            $table->string('autoresponse_reply_to')->nullable()->after('autoresponse_from_email');
        });
    }

    public function down(): void
    {
        Schema::table('product_forms', function (Blueprint $table) {
            $table->dropColumn([
                'autoresponse_enabled',
                'autoresponse_subject',
                'autoresponse_body',
                'autoresponse_from_name',
                'autoresponse_from_email',
                'autoresponse_reply_to',
            ]);
        });
    }
};
