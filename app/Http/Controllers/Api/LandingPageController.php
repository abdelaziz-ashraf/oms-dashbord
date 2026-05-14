<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(string $slug): JsonResponse
    {
        $landingPage = LandingPage::with([
            'announcement',
            'hero.statistics',
            'problem.items',
            'features.features',
            'packages.packages.features',
            'targetAudience.items',
            'socialProof.items',
            'whyUs.items',
            'howItWorks.steps',
            'comparison.items',
            'faq.items',
            'cta',
            'contact.items',
            'footer.linkGroups.links',
            'footer.socialLinks',
        ])->where('slug', $slug)->first();

        if (!$landingPage) {
            return response()->json(['error' => 'Landing page not found'], 404);
        }

        return response()->json($this->formatLandingPageData($landingPage));
    }

    private function formatLandingPageData($page)
    {
        return [
            'id' => $page->id,
            'slug' => $page->slug,
            'name' => $page->name,
            'is_announcement_active' => $page->is_announcement_active,
            'announcement_text_en' => $page->announcement?->text_en,
            'announcement_text_ar' => $page->announcement?->text_ar,
            'announcement_link' => $page->announcement?->link,
            'logo_text_en' => $page->logo_text_en,
            'logo_text_ar' => $page->logo_text_ar,
            'hero' => $this->formatHero($page->hero),
            'problem' => $this->formatProblem($page->problem),
            'features' => $this->formatFeatures($page->features),
            'packages' => $this->formatPackages($page->packages),
            'target_audience' => $this->formatTargetAudience($page->targetAudience),
            'social_proof' => $this->formatSocialProof($page->socialProof),
            'why_us' => $this->formatWhyUs($page->whyUs),
            'how_it_works' => $this->formatHowItWorks($page->howItWorks),
            'comparison' => $this->formatComparison($page->comparison),
            'faq' => $this->formatFaq($page->faq),
            'cta' => $this->formatCta($page->cta),
            'contact' => $this->formatContact($page->contact),
            'footer' => $this->formatFooter($page->footer),
        ];
    }

    private function formatHero($hero)
    {
        if (!$hero) return null;

        return [
            'id' => $hero->id,
            'is_active' => $hero->is_active,
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
            'statistics' => $hero->statistics->map(fn($s) => [
                'value' => $s->value,
                'label_en' => $s->label_en,
                'label_ar' => $s->label_ar,
            ])->toArray(),
        ];
    }

    private function formatSection($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en ?? '',
            'title_ar' => $section->title_ar ?? '',
            'description_en' => $section->description_en ?? '',
            'description_ar' => $section->description_ar ?? '',
        ];
    }

    private function formatProblem($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en ?? '',
            'title_ar' => $section->title_ar ?? '',
            'description_en' => $section->description_en ?? '',
            'description_ar' => $section->description_ar ?? '',
            'items' => $section->items->map(fn($i) => [
                'title_en' => $i->title_en,
                'title_ar' => $i->title_ar,
                'description_en' => $i->description_en,
                'description_ar' => $i->description_ar,
                'icon' => $i->icon,
            ])->toArray(),
        ];
    }

    private function formatFeatures($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'features' => $section->features->map(fn($f) => [
                'title_en' => $f->title_en,
                'title_ar' => $f->title_ar,
                'description_en' => $f->description_en,
                'description_ar' => $f->description_ar,
                'icon' => $f->icon,
            ])->toArray(),
        ];
    }

    private function formatPackages($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'popular_badge_en' => $section->popular_badge_en,
            'popular_badge_ar' => $section->popular_badge_ar,
            'billing_period_en' => $section->billing_period_en,
            'billing_period_ar' => $section->billing_period_ar,
            'plans' => $section->packages->map(fn($p) => [
                'name_en' => $p->name_en,
                'name_ar' => $p->name_ar,
                'users_en' => $p->users_en,
                'users_ar' => $p->users_ar,
                'description_en' => $p->description_en,
                'description_ar' => $p->description_ar,
                'price' => $p->price,
                'button_text_en' => $p->button_text_en,
                'button_text_ar' => $p->button_text_ar,
                'features_en' => $p->features->pluck('name_en')->toArray(),
                'features_ar' => $p->features->pluck('name_ar')->toArray(),
            ])->toArray(),
        ];
    }

    private function formatTargetAudience($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'items' => $section->items->map(fn($i) => [
                'title_en' => $i->title_en,
                'title_ar' => $i->title_ar,
                'description_en' => $i->description_en,
                'description_ar' => $i->description_ar,
                'icon' => $i->icon,
            ])->toArray(),
        ];
    }

    private function formatSocialProof($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'items' => $section->items->map(fn($i) => [
                'company' => $i->company,
                'metric' => $i->metric,
                'quote_en' => $i->quote_en,
                'quote_ar' => $i->quote_ar,
            ])->toArray(),
        ];
    }

    private function formatWhyUs($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'items' => $section->items->map(fn($i) => [
                'title_en' => $i->title_en,
                'title_ar' => $i->title_ar,
                'description_en' => $i->description_en,
                'description_ar' => $i->description_ar,
                'icon' => $i->icon,
            ])->toArray(),
        ];
    }

    private function formatHowItWorks($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'steps' => $section->steps->map(fn($s) => [
                'title_en' => $s->title_en,
                'title_ar' => $s->title_ar,
                'description_en' => $s->description_en,
                'description_ar' => $s->description_ar,
            ])->toArray(),
        ];
    }

    private function formatComparison($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'items' => $section->items->map(fn($i) => [
                'icon' => $i->icon,
                'text_en' => $i->text_en,
                'text_ar' => $i->text_ar,
                'color' => $i->color,
            ])->toArray(),
        ];
    }

    private function formatFaq($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'items' => $section->items->map(fn($i) => [
                'question_en' => $i->question_en,
                'question_ar' => $i->question_ar,
                'answer_en' => $i->answer_en,
                'answer_ar' => $i->answer_ar,
            ])->toArray(),
        ];
    }

    private function formatCta($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'button_text_en' => $section->button_text_en,
            'button_text_ar' => $section->button_text_ar,
            'button_link' => $section->button_link,
        ];
    }

    private function formatContact($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'title_en' => $section->title_en,
            'title_ar' => $section->title_ar,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'items' => $section->items->map(fn($i) => [
                'icon' => $i->icon,
                'label_en' => $i->label_en,
                'label_ar' => $i->label_ar,
                'value' => $i->value,
            ])->toArray(),
        ];
    }

    private function formatFooter($section)
    {
        if (!$section) return null;
        return [
            'id' => $section->id,
            'is_active' => $section->is_active,
            'description_en' => $section->description_en,
            'description_ar' => $section->description_ar,
            'copyright_en' => $section->copyright_en,
            'copyright_ar' => $section->copyright_ar,
            'link_groups' => $section->linkGroups->map(fn($g) => [
                'key' => $g->key,
                'title_en' => $g->title_en,
                'title_ar' => $g->title_ar,
                'links' => $g->links->map(fn($l) => [
                    'label_en' => $l->label_en,
                    'label_ar' => $l->label_ar,
                    'url' => $l->url,
                ])->toArray(),
            ])->toArray(),
            'social_links' => $section->socialLinks->map(fn($s) => [
                'platform' => $s->platform,
                'url' => $s->url,
            ])->toArray(),
        ];
    }
}