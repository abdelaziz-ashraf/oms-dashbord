<?php

namespace App\Http\Resources;

use App\Models\PortfolioSection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingPageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $page = $this->resource;
        $announcement = $page->is_announcement_active && $page->announcement?->is_active
            ? $page->announcement
            : null;

        return [
            'id' => $page->id,
            'slug' => $page->slug,
            'name' => $page->name,
            'is_announcement_active' => (bool) $page->is_announcement_active,
            'announcement_text_en' => $announcement?->text_en,
            'announcement_text_ar' => $announcement?->text_ar,
            'announcement_link' => $announcement?->link,
            'logo_text_en' => $page->logo_text_en,
            'logo_text_ar' => $page->logo_text_ar,
            'logo_image_path' => $page->logo_image_path,
            'logo_image_url' => $page->logo_image_path ? $this->mediaUrl($page->logo_image_path) : null,
            'navigation' => $this->navigation($page),
            'hero' => $this->hero($page->hero),
            'problem' => $this->sectionWithItems($page->problem, 'items', [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ]),
            'features' => $this->sectionWithItems($page->features, 'features', [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ]),
            'packages' => $this->packages($page->packages),
            'target_audience' => $this->sectionWithItems($page->targetAudience, 'items', [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ]),
            'social_proof' => $this->sectionWithItems($page->socialProof, 'items', [
                'company', 'metric', 'quote_en', 'quote_ar',
            ]),
            'why_us' => $this->sectionWithItems($page->whyUs, 'items', [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ]),
            'how_it_works' => $this->howItWorks($page->howItWorks),
            'comparison' => $this->comparison($page->comparison),
            'faq' => $this->sectionWithItems($page->faq, 'items', [
                'question_en', 'question_ar', 'answer_en', 'answer_ar',
            ]),
            'cta' => $this->cta($page->cta),
            'contact' => $this->contact($page->contact),
            'footer' => $this->footer($page->footer),
            'portfolio' => $this->portfolio($request),
        ];
    }

    private function hero($hero): ?array
    {
        if (!$hero) {
            return null;
        }

        return [
            'id' => $hero->id,
            'is_active' => (bool) $hero->is_active,
            'title_en' => $hero->title_en,
            'title_ar' => $hero->title_ar,
            'subtitle_en' => $hero->subtitle_en,
            'subtitle_ar' => $hero->subtitle_ar,
            'button_text_en' => $hero->button_text_en,
            'button_text_ar' => $hero->button_text_ar,
            'button_link' => $hero->button_link,
            'secondary_button_text_en' => $hero->secondary_button_text_en,
            'secondary_button_text_ar' => $hero->secondary_button_text_ar,
            'secondary_button_link' => $hero->secondary_button_link,
            'trusted_badge_en' => $hero->trusted_badge_en,
            'trusted_badge_ar' => $hero->trusted_badge_ar,
            'statistics' => $hero->statistics->map(fn ($stat) => [
                'id' => $stat->id,
                'value' => $stat->value,
                'label_en' => $stat->label_en,
                'label_ar' => $stat->label_ar,
            ])->values()->all(),
        ];
    }

    private function sectionBase($section): ?array
    {
        if (!$section) {
            return null;
        }

        return [
            'id' => $section->id,
            'is_active' => (bool) $section->is_active,
            'eyebrow_en' => $section->eyebrow_en,
            'eyebrow_ar' => $section->eyebrow_ar,
            'title_en' => $section->title_en ?? null,
            'title_ar' => $section->title_ar ?? null,
            'description_en' => $section->description_en ?? null,
            'description_ar' => $section->description_ar ?? null,
        ];
    }

    private function sectionWithItems($section, string $relation, array $fields): ?array
    {
        $base = $this->sectionBase($section);

        if (!$base) {
            return null;
        }

        $base[$relation] = $section->{$relation}->map(
            fn ($item) => $this->onlyModelFields($item, $fields)
        )->values()->all();

        return $base;
    }

    private function packages($section): ?array
    {
        $base = $this->sectionBase($section);

        if (!$base) {
            return null;
        }

        return $base + [
            'popular_badge_en' => $section->popular_badge_en,
            'popular_badge_ar' => $section->popular_badge_ar,
            'billing_period_en' => $section->billing_period_en,
            'billing_period_ar' => $section->billing_period_ar,
            'plans' => $section->packages->map(fn ($package) => [
                'id' => $package->id,
                'name_en' => $package->name_en,
                'name_ar' => $package->name_ar,
                'users_en' => $package->users_en,
                'users_ar' => $package->users_ar,
                'description_en' => $package->description_en,
                'description_ar' => $package->description_ar,
                'price' => $package->price,
                'button_text_en' => $package->button_text_en,
                'button_text_ar' => $package->button_text_ar,
                'is_popular' => (bool) $package->is_popular,
                'features_en' => $package->features->pluck('name_en')->values()->all(),
                'features_ar' => $package->features->pluck('name_ar')->values()->all(),
            ])->values()->all(),
        ];
    }

    private function howItWorks($section): ?array
    {
        $base = $this->sectionWithItems($section, 'steps', [
            'title_en', 'title_ar', 'description_en', 'description_ar',
        ]);

        if (!$base) {
            return null;
        }

        return $base + [
            'cta_title_en' => $section->cta_title_en,
            'cta_title_ar' => $section->cta_title_ar,
            'cta_description_en' => $section->cta_description_en,
            'cta_description_ar' => $section->cta_description_ar,
            'cta_button_text_en' => $section->cta_button_text_en,
            'cta_button_text_ar' => $section->cta_button_text_ar,
            'cta_button_link' => $section->cta_button_link,
            'cta_secondary_button_text_en' => $section->cta_secondary_button_text_en,
            'cta_secondary_button_text_ar' => $section->cta_secondary_button_text_ar,
            'cta_secondary_button_link' => $section->cta_secondary_button_link,
        ];
    }

    private function comparison($section): ?array
    {
        $base = $this->sectionWithItems($section, 'items', [
            'icon', 'text_en', 'text_ar', 'color',
        ]);

        if (!$base) {
            return null;
        }

        return $base + [
            'before_title_en' => $section->before_title_en,
            'before_title_ar' => $section->before_title_ar,
            'before_subtitle_en' => $section->before_subtitle_en,
            'before_subtitle_ar' => $section->before_subtitle_ar,
            'after_title_en' => $section->after_title_en,
            'after_title_ar' => $section->after_title_ar,
            'after_subtitle_en' => $section->after_subtitle_en,
            'after_subtitle_ar' => $section->after_subtitle_ar,
        ];
    }

    private function cta($section): ?array
    {
        $base = $this->sectionBase($section);

        if (!$base) {
            return null;
        }

        return $base + [
            'button_text_en' => $section->button_text_en,
            'button_text_ar' => $section->button_text_ar,
            'button_link' => $section->button_link,
            'secondary_button_text_en' => $section->secondary_button_text_en,
            'secondary_button_text_ar' => $section->secondary_button_text_ar,
            'secondary_button_link' => $section->secondary_button_link,
            'badges' => $section->badges ?? [],
        ];
    }

    private function contact($section): ?array
    {
        $base = $this->sectionWithItems($section, 'items', [
            'icon', 'label_en', 'label_ar', 'value',
        ]);

        if (!$base) {
            return null;
        }

        foreach ([
            'form_title_en', 'form_title_ar', 'form_description_en', 'form_description_ar',
            'form_button_text_en', 'form_button_text_ar', 'form_success_text_en', 'form_success_text_ar',
            'form_error_text_en', 'form_error_text_ar', 'form_sending_text_en', 'form_sending_text_ar',
            'form_name_label_en', 'form_name_label_ar', 'form_name_placeholder_en', 'form_name_placeholder_ar',
            'form_email_label_en', 'form_email_label_ar', 'form_email_placeholder_en', 'form_email_placeholder_ar',
            'form_company_label_en', 'form_company_label_ar', 'form_company_placeholder_en', 'form_company_placeholder_ar',
        ] as $field) {
            $base[$field] = $section->{$field};
        }

        $base['form_badges'] = $section->form_badges ?? [];

        return $base;
    }

    private function footer($section): ?array
    {
        if (!$section) {
            return null;
        }

        return [
            'id' => $section->id,
            'is_active' => (bool) $section->is_active,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'copyright_en' => $section->copyright_en,
            'copyright_ar' => $section->copyright_ar,
            'link_groups' => $section->linkGroups->map(fn ($group) => [
                'id' => $group->id,
                'key' => $group->key,
                'title_en' => $group->title_en,
                'title_ar' => $group->title_ar,
                'links' => $group->links->map(fn ($link) => [
                    'id' => $link->id,
                    'label_en' => $link->label_en,
                    'label_ar' => $link->label_ar,
                    'url' => $link->url,
                ])->values()->all(),
            ])->values()->all(),
            'social_links' => $section->socialLinks->map(fn ($social) => [
                'id' => $social->id,
                'platform' => $social->platform,
                'url' => $social->url,
            ])->values()->all(),
        ];
    }

    private function navigation($page): array
    {
        return collect([
            ['href' => '#features', 'section' => $page->features],
            ['href' => '#packages', 'section' => $page->packages],
            ['href' => '#how-it-works', 'section' => $page->howItWorks],
            ['href' => '#contact', 'section' => $page->contact],
        ])
            ->filter(fn (array $item) => $item['section']?->is_active)
            ->map(fn (array $item) => [
                'href' => $item['href'],
                'label_en' => $item['section']->eyebrow_en ?: $item['section']->title_en,
                'label_ar' => $item['section']->eyebrow_ar ?: $item['section']->title_ar,
            ])
            ->values()
            ->all();
    }

    private function portfolio(Request $request): array
    {
        return PortfolioSection::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->mapWithKeys(fn (PortfolioSection $section) => [
                $section->module => (new PortfolioSectionResource($section))->resolve($request),
            ])
            ->all();
    }

    private function onlyModelFields($model, array $fields): array
    {
        $data = ['id' => $model->getKey()];

        foreach ($fields as $field) {
            $data[$field] = $model->{$field};
        }

        return $data;
    }

    private function mediaUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return url($path);
        }

        return url(Storage::disk('public')->url($path));
    }
}
