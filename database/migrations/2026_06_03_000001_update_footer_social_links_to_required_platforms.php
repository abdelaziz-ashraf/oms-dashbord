<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $platforms = [
        ['platform' => 'facebook', 'url' => 'https://facebook.com/oms'],
        ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/oms'],
        ['platform' => 'instagram', 'url' => 'https://instagram.com/oms'],
        ['platform' => 'tiktok', 'url' => 'https://www.tiktok.com/@oms'],
    ];

    public function up(): void
    {
        DB::table('footer_sections')
            ->pluck('id')
            ->each(function (int $footerSectionId): void {
                $existingUrls = DB::table('social_links')
                    ->where('footer_section_id', $footerSectionId)
                    ->get()
                    ->mapWithKeys(fn ($link) => [strtolower($link->platform) => $link->url]);

                DB::table('social_links')
                    ->where('footer_section_id', $footerSectionId)
                    ->delete();

                foreach ($this->platforms as $order => $link) {
                    DB::table('social_links')->insert([
                        'footer_section_id' => $footerSectionId,
                        'platform' => $link['platform'],
                        'url' => $existingUrls[$link['platform']] ?? $link['url'],
                        'order' => $order,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }

    public function down(): void
    {
        $previousPlatforms = [
            ['platform' => 'twitter', 'url' => 'https://twitter.com/oms'],
            ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/oms'],
            ['platform' => 'facebook', 'url' => 'https://facebook.com/oms'],
        ];

        DB::table('footer_sections')
            ->pluck('id')
            ->each(function (int $footerSectionId) use ($previousPlatforms): void {
                $existingUrls = DB::table('social_links')
                    ->where('footer_section_id', $footerSectionId)
                    ->get()
                    ->mapWithKeys(fn ($link) => [strtolower($link->platform) => $link->url]);

                DB::table('social_links')
                    ->where('footer_section_id', $footerSectionId)
                    ->delete();

                foreach ($previousPlatforms as $order => $link) {
                    DB::table('social_links')->insert([
                        'footer_section_id' => $footerSectionId,
                        'platform' => $link['platform'],
                        'url' => $existingUrls[$link['platform']] ?? $link['url'],
                        'order' => $order,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }
};
