<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cta_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('cta_sections', 'whatsapp_number')) {
                $table->string('whatsapp_number', 32)->nullable()->after('secondary_button_link');
            }
        });

        $defaultWhatsappNumber = DB::table('contact_items')
            ->where('label_en', 'like', '%phone%')
            ->value('value') ?? '+1234567890';

        DB::table('cta_sections')->update([
            'whatsapp_number' => $defaultWhatsappNumber,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('cta_sections', function (Blueprint $table) {
            if (Schema::hasColumn('cta_sections', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
        });
    }
};
