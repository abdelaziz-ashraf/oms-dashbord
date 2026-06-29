<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_sections', 'whatsapp_number')) {
                $table->string('whatsapp_number', 32)->nullable()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_sections', function (Blueprint $table) {
            if (Schema::hasColumn('contact_sections', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
        });
    }
};
