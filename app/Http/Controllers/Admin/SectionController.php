<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SectionRequest;
use App\Models\Announcement;
use App\Models\ComparisonSection;
use App\Models\ContactSection;
use App\Models\CtaSection;
use App\Models\FaqSection;
use App\Models\FeaturesSection;
use App\Models\FooterSection;
use App\Models\HeroSection;
use App\Models\HowItWorksSection;
use App\Models\LandingPage;
use App\Models\PackagesSection;
use App\Models\Package;
use App\Models\ProblemSection;
use App\Models\SocialProof;
use App\Models\TargetAudience;
use App\Models\WhyUsSection;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    private function getLandingPage(): LandingPage
    {
        return LandingPage::firstOrCreate(
            ['slug' => 'oms'],
            ['name' => 'OMS Landing Page']
        );
    }

    public function updateAnnouncement(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $page = $this->getLandingPage();
            $isActive = $request->boolean('is_active');

            Announcement::updateOrCreate(
                ['landing_page_id' => $page->id],
                [
                    'text_en' => $request->validated('text_en'),
                    'text_ar' => $request->validated('text_ar'),
                    'link' => $request->validated('link'),
                    'is_active' => $isActive,
                ]
            );

            $page->forceFill(['is_announcement_active' => $isActive])->save();
        });

        return back()->with('success', 'Announcement updated!');
    }

    public function updateHero(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $page = $this->getLandingPage();
            $hero = HeroSection::updateOrCreate(
                ['landing_page_id' => $page->id],
                $this->sectionPayload($request, [
                    'title_en', 'title_ar', 'subtitle_en', 'subtitle_ar',
                    'button_text_en', 'button_text_ar', 'button_link',
                    'secondary_button_text_en', 'secondary_button_text_ar',
                    'secondary_button_link', 'trusted_badge_en', 'trusted_badge_ar',
                ])
            );

            $this->syncChildren(
                $hero->statistics(),
                $request->validated('statistics') ?? [],
                ['value', 'label_en', 'label_ar'],
                fn (array $row) => filled($row['value'] ?? null)
            );
        });

        return back()->with('success', 'Hero section updated!');
    }

    public function updateProblem(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, ProblemSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
            ]);

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ], fn (array $row) => filled($row['title_en'] ?? null));
        });

        return back()->with('success', 'Problem section updated!');
    }

    public function updateFeatures(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, FeaturesSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
            ]);

            $this->syncChildren($section->features(), $request->validated('features') ?? [], [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ], fn (array $row) => filled($row['title_en'] ?? null));
        });

        return back()->with('success', 'Features section updated!');
    }

    public function updatePackages(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, PackagesSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
                'popular_badge_en', 'popular_badge_ar', 'billing_period_en',
                'billing_period_ar',
            ]);

            $packageRows = collect($request->validated('packages') ?? [])
                ->map(function (array $row, int $index) use ($request): array {
                    $row['is_popular'] = $request->boolean("packages.$index.is_popular");

                    return $row;
                })
                ->all();

            $packages = $this->syncChildren(
                $section->packages(),
                $packageRows,
                [
                    'name_en', 'name_ar', 'users_en', 'users_ar',
                    'description_en', 'description_ar', 'price',
                    'button_text_en', 'button_text_ar', 'is_popular',
                ],
                fn (array $row) => filled($row['name_en'] ?? null)
            );

            foreach ($packages as $inputIndex => $package) {
                $this->syncPackageFeatures(
                    $package,
                    $request->input("packages.$inputIndex.features_text", '')
                );
            }
        });

        return back()->with('success', 'Packages section updated!');
    }

    public function updateTargetAudience(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, TargetAudience::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
            ]);

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ], fn (array $row) => filled($row['title_en'] ?? null));
        });

        return back()->with('success', 'Target audience section updated!');
    }

    public function updateSocialProof(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, SocialProof::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
            ]);

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'company', 'metric', 'quote_en', 'quote_ar',
            ], fn (array $row) => filled($row['company'] ?? null));
        });

        return back()->with('success', 'Social proof section updated!');
    }

    public function updateWhyUs(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, WhyUsSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
            ]);

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'title_en', 'title_ar', 'description_en', 'description_ar', 'icon',
            ], fn (array $row) => filled($row['title_en'] ?? null));
        });

        return back()->with('success', 'Why us section updated!');
    }

    public function updateHowItWorks(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, HowItWorksSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
                'cta_title_en', 'cta_title_ar', 'cta_description_en', 'cta_description_ar',
                'cta_button_text_en', 'cta_button_text_ar', 'cta_button_link',
                'cta_secondary_button_text_en', 'cta_secondary_button_text_ar',
                'cta_secondary_button_link',
            ]);

            $this->syncChildren($section->steps(), $request->validated('steps') ?? [], [
                'title_en', 'title_ar', 'description_en', 'description_ar',
            ], fn (array $row) => filled($row['title_en'] ?? null));
        });

        return back()->with('success', 'How it works section updated!');
    }

    public function updateComparison(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, ComparisonSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
                'before_title_en', 'before_title_ar', 'before_subtitle_en', 'before_subtitle_ar',
                'after_title_en', 'after_title_ar', 'after_subtitle_en', 'after_subtitle_ar',
            ]);

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'icon', 'text_en', 'text_ar', 'color',
            ], fn (array $row) => filled($row['text_en'] ?? null));
        });

        return back()->with('success', 'Comparison section updated!');
    }

    public function updateFaq(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, FaqSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
            ]);

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'question_en', 'question_ar', 'answer_en', 'answer_ar',
            ], fn (array $row) => filled($row['question_en'] ?? null));
        });

        return back()->with('success', 'FAQ section updated!');
    }

    public function updateCta(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, CtaSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
                'button_text_en', 'button_text_ar', 'button_link',
                'secondary_button_text_en', 'secondary_button_text_ar', 'secondary_button_link',
                'whatsapp_number',
            ]);

            $section->forceFill([
                'badges' => $this->parseLocalizedLines($request->validated('badges_text')),
            ])->save();
        });

        return back()->with('success', 'CTA section updated!');
    }

    public function updateContact(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, ContactSection::class, [
                'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar',
                'form_title_en', 'form_title_ar', 'form_description_en', 'form_description_ar',
                'form_button_text_en', 'form_button_text_ar', 'form_success_text_en',
                'form_success_text_ar', 'form_error_text_en', 'form_error_text_ar',
                'form_sending_text_en', 'form_sending_text_ar', 'form_name_label_en',
                'form_name_label_ar', 'form_name_placeholder_en', 'form_name_placeholder_ar',
                'form_email_label_en', 'form_email_label_ar', 'form_email_placeholder_en',
                'form_email_placeholder_ar', 'form_company_label_en', 'form_company_label_ar',
                'form_company_placeholder_en', 'form_company_placeholder_ar',
                'whatsapp_number',
            ]);

            $section->forceFill([
                'form_badges' => $this->parseLocalizedLines($request->validated('form_badges_text')),
            ])->save();

            $this->syncChildren($section->items(), $request->validated('items') ?? [], [
                'icon', 'label_en', 'label_ar', 'value',
            ], fn (array $row) => filled($row['icon'] ?? null) || filled($row['label_en'] ?? null));
        });

        return back()->with('success', 'Contact section updated!');
    }

    public function updateFooter(SectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $section = $this->updateSingletonSection($request, FooterSection::class, [
                'description_en', 'description_ar', 'copyright_en', 'copyright_ar',
            ]);

            $groups = $this->syncChildren($section->linkGroups(), $request->validated('link_groups') ?? [], [
                'key', 'title_en', 'title_ar',
            ], fn (array $row) => filled($row['title_en'] ?? null));

            foreach ($groups as $inputIndex => $group) {
                $links = $request->validated("link_groups.$inputIndex.links") ?? [];
                $this->syncChildren($group->links(), $links, [
                    'label_en', 'label_ar', 'url',
                ], fn (array $row) => filled($row['label_en'] ?? null));
            }

            $socialLinks = collect($request->validated('social_links') ?? [])
                ->map(function (array $row): array {
                    $row['platform'] = strtolower(trim((string) ($row['platform'] ?? '')));

                    return $row;
                })
                ->all();

            $this->syncChildren($section->socialLinks(), $socialLinks, [
                'platform', 'url',
            ], fn (array $row) => filled($row['platform'] ?? null) && filled($row['url'] ?? null));
        });

        return back()->with('success', 'Footer section updated!');
    }

    private function updateSingletonSection(SectionRequest $request, string $modelClass, array $fields): Model
    {
        $page = $this->getLandingPage();

        return $modelClass::updateOrCreate(
            ['landing_page_id' => $page->id],
            $this->sectionPayload($request, $fields)
        );
    }

    private function sectionPayload(SectionRequest $request, array $fields): array
    {
        $payload = Arr::only($request->validated(), $fields);
        $payload['is_active'] = $request->boolean('is_active');

        return $payload;
    }

    /**
     * @return array<int, Model>
     */
    private function syncChildren(HasMany $relation, array $rows, array $fields, Closure $shouldKeep): array
    {
        $syncedModels = [];
        $keptIds = [];

        foreach ($rows as $inputIndex => $row) {
            if (!$shouldKeep($row)) {
                continue;
            }

            $payload = Arr::only($row, $fields);
            $payload['order'] = (int) $inputIndex;

            $model = $this->findRelatedChild($relation, $row['id'] ?? null);

            if (!$model) {
                $model = $relation->create($payload);
            } else {
                $model->fill($payload)->save();
            }

            $keptIds[] = $model->getKey();
            $syncedModels[$inputIndex] = $model;
        }

        $this->deleteMissingChildren($relation, $keptIds);

        return $syncedModels;
    }

    private function syncPackageFeatures(Package $package, ?string $featuresText): void
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $featuresText);
        $existing = $package->features()->orderBy('order')->get()->values();
        $keptIds = [];
        $order = 0;

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            [$nameEn, $nameAr] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);

            if ($nameEn === '') {
                continue;
            }

            $feature = $existing->get($order) ?? $package->features()->make();
            $feature->fill([
                'name_en' => $nameEn,
                'name_ar' => $nameAr ?: $nameEn,
                'order' => $order,
            ]);
            $feature->save();

            $keptIds[] = $feature->getKey();
            $order++;
        }

        $this->deleteMissingChildren($package->features(), $keptIds);
    }

    private function findRelatedChild(HasMany $relation, mixed $id): ?Model
    {
        if (!$id) {
            return null;
        }

        return $relation->getRelated()
            ->newQuery()
            ->where($relation->getForeignKeyName(), $relation->getParent()->getKey())
            ->whereKey($id)
            ->first();
    }

    private function deleteMissingChildren(HasMany $relation, array $keptIds): void
    {
        $query = $relation->getRelated()
            ->newQuery()
            ->where($relation->getForeignKeyName(), $relation->getParent()->getKey());

        if ($keptIds !== []) {
            $query->whereNotIn($relation->getRelated()->getKeyName(), $keptIds);
        }

        $query->delete();
    }

    private function parseLocalizedLines(?string $lines): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $lines))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->map(function (string $line): array {
                [$textEn, $textAr] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);

                return [
                    'text_en' => $textEn,
                    'text_ar' => $textAr ?: $textEn,
                ];
            })
            ->values()
            ->all();
    }
}
