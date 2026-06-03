<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $singletonTables = [
        'announcements',
        'hero_sections',
        'problem_sections',
        'features_sections',
        'packages_sections',
        'target_audiences',
        'social_proofs',
        'why_us_sections',
        'how_it_works_sections',
        'comparison_sections',
        'faq_sections',
        'cta_sections',
        'contact_sections',
        'footer_sections',
    ];

    public function up(): void
    {
        foreach ($this->singletonTables as $table) {
            $this->deleteDuplicateSingletonRows($table);

            Schema::table($table, function (Blueprint $table) {
                $table->unique('landing_page_id');
            });
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->singletonTables) as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropUnique($tableName.'_landing_page_id_unique');
            });
        }
    }

    private function deleteDuplicateSingletonRows(string $table): void
    {
        $groups = DB::table($table)
            ->select('landing_page_id', DB::raw('MAX(id) as keep_id'), DB::raw('COUNT(*) as total'))
            ->groupBy('landing_page_id')
            ->having('total', '>', 1)
            ->get();

        foreach ($groups as $group) {
            DB::table($table)
                ->where('landing_page_id', $group->landing_page_id)
                ->where('id', '<>', $group->keep_id)
                ->delete();
        }
    }
};
