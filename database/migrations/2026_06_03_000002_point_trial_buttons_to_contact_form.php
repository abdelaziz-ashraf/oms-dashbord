<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('hero_sections')
            ->where('button_link', '#packages')
            ->update(['button_link' => '#contact', 'updated_at' => now()]);

        DB::table('cta_sections')
            ->where('button_link', '#packages')
            ->update(['button_link' => '#contact', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('hero_sections')
            ->where('button_link', '#contact')
            ->update(['button_link' => '#packages', 'updated_at' => now()]);

        DB::table('cta_sections')
            ->where('button_link', '#contact')
            ->update(['button_link' => '#packages', 'updated_at' => now()]);
    }
};
