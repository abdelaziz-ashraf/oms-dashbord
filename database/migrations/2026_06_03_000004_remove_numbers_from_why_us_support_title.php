<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('why_us_items')
            ->where('title_en', '24/7 Support')
            ->update([
                'title_en' => 'Dedicated Support',
                'title_ar' => 'دعم مخصص',
                'description_en' => 'Responsive assistance when you need it',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('why_us_items')
            ->where('title_en', 'Dedicated Support')
            ->where('title_ar', 'دعم مخصص')
            ->update([
                'title_en' => '24/7 Support',
                'title_ar' => 'دعم على مدار الساعة',
                'description_en' => 'Round-the-clock assistance when you need it',
                'updated_at' => now(),
            ]);
    }
};
