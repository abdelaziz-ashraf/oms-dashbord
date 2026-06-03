<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $withoutOmsItems = [
        ['text_en' => 'Scattered tools', 'text_ar' => 'أدوات متفرقة'],
        ['text_en' => 'Manual follow-up', 'text_ar' => 'متابعة يدوية'],
        ['text_en' => 'Missed renewals', 'text_ar' => 'تجديدات فائتة'],
        ['text_en' => 'Limited visibility', 'text_ar' => 'رؤية محدودة'],
    ];

    public function up(): void
    {
        DB::table('comparison_sections')
            ->orderBy('id')
            ->get()
            ->each(function ($section): void {
                DB::table('comparison_sections')
                    ->where('id', $section->id)
                    ->update([
                        'before_title_en' => $section->before_title_en ?: 'Without OMS',
                        'before_title_ar' => $section->before_title_ar ?: 'بدون النظام',
                        'before_subtitle_en' => $section->before_subtitle_en ?: 'The old way',
                        'before_subtitle_ar' => $section->before_subtitle_ar ?: 'الطريقة القديمة',
                        'after_title_en' => $section->after_title_en ?: 'With OMS',
                        'after_title_ar' => $section->after_title_ar ?: 'مع النظام',
                        'after_subtitle_en' => $section->after_subtitle_en ?: 'The smart way',
                        'after_subtitle_ar' => $section->after_subtitle_ar ?: 'الطريقة الذكية',
                        'updated_at' => now(),
                    ]);

                $hasWithoutOmsItems = DB::table('comparison_items')
                    ->where('comparison_section_id', $section->id)
                    ->where('color', 'red')
                    ->exists();

                DB::table('comparison_items')
                    ->where('comparison_section_id', $section->id)
                    ->whereNotIn('color', ['red', 'green'])
                    ->update([
                        'color' => 'green',
                        'updated_at' => now(),
                    ]);

                if ($hasWithoutOmsItems) {
                    return;
                }

                $firstGreenOrder = DB::table('comparison_items')
                    ->where('comparison_section_id', $section->id)
                    ->min('order') ?? 0;

                DB::table('comparison_items')
                    ->where('comparison_section_id', $section->id)
                    ->increment('order', count($this->withoutOmsItems));

                foreach ($this->withoutOmsItems as $index => $item) {
                    DB::table('comparison_items')->insert([
                        'comparison_section_id' => $section->id,
                        'icon' => 'x-circle',
                        'text_en' => $item['text_en'],
                        'text_ar' => $item['text_ar'],
                        'color' => 'red',
                        'order' => $firstGreenOrder + $index,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }

    public function down(): void
    {
        DB::table('comparison_items')
            ->where('color', 'red')
            ->whereIn('text_en', array_column($this->withoutOmsItems, 'text_en'))
            ->delete();
    }
};
