<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match ($this->route()?->getName()) {
            'admin.announcement.update' => [
                'text_en' => ['required', 'string'],
                'text_ar' => ['required', 'string'],
                'link' => ['nullable', 'string', 'max:2048'],
                'is_active' => ['nullable', 'boolean'],
            ],
            'admin.hero.update' => $this->heroRules(),
            'admin.problem.update' => $this->sectionWithItemsRules('items'),
            'admin.features.update' => $this->sectionWithItemsRules('features', true),
            'admin.packages.update' => $this->packagesRules(),
            'admin.audience.update' => $this->sectionWithItemsRules('items', true),
            'admin.social-proof.update' => $this->socialProofRules(),
            'admin.why-us.update' => $this->sectionWithItemsRules('items', true),
            'admin.how-it-works.update' => $this->howItWorksRules(),
            'admin.comparison.update' => $this->comparisonRules(),
            'admin.faq.update' => $this->faqRules(),
            'admin.cta.update' => [
                'eyebrow_en' => ['nullable', 'string'],
                'eyebrow_ar' => ['nullable', 'string'],
                'title_en' => ['required', 'string'],
                'title_ar' => ['required', 'string'],
                'description_en' => ['nullable', 'string'],
                'description_ar' => ['nullable', 'string'],
                'button_text_en' => ['required', 'string'],
                'button_text_ar' => ['required', 'string'],
                'button_link' => ['nullable', 'string', 'max:2048'],
                'secondary_button_text_en' => ['nullable', 'string'],
                'secondary_button_text_ar' => ['nullable', 'string'],
                'secondary_button_link' => ['nullable', 'string', 'max:2048'],
                'whatsapp_number' => ['nullable', 'string', 'max:32'],
                'badges_text' => ['nullable', 'string'],
                'is_active' => ['nullable', 'boolean'],
            ],
            'admin.contact.update' => $this->contactRules(),
            'admin.footer.update' => $this->footerRules(),
            default => [],
        };
    }

    private function baseSectionRules(bool $descriptionNullable = true): array
    {
        return [
            'eyebrow_en' => ['nullable', 'string'],
            'eyebrow_ar' => ['nullable', 'string'],
            'title_en' => ['required', 'string'],
            'title_ar' => ['required', 'string'],
            'description_en' => [$descriptionNullable ? 'nullable' : 'required', 'string'],
            'description_ar' => [$descriptionNullable ? 'nullable' : 'required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    private function sectionWithItemsRules(string $key, bool $icon = false): array
    {
        return $this->baseSectionRules($key !== 'items' || $this->route()?->getName() !== 'admin.problem.update') + [
            $key => ['nullable', 'array'],
            $key.'.*.id' => ['nullable', 'integer'],
            $key.'.*.title_en' => ['nullable', 'string'],
            $key.'.*.title_ar' => ['nullable', 'string'],
            $key.'.*.description_en' => ['nullable', 'string'],
            $key.'.*.description_ar' => ['nullable', 'string'],
            $key.'.*.icon' => [$icon ? 'nullable' : 'sometimes', 'string'],
        ];
    }

    private function heroRules(): array
    {
        return [
            'title_en' => ['required', 'string'],
            'title_ar' => ['required', 'string'],
            'subtitle_en' => ['required', 'string'],
            'subtitle_ar' => ['required', 'string'],
            'button_text_en' => ['required', 'string'],
            'button_text_ar' => ['required', 'string'],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'secondary_button_text_en' => ['nullable', 'string'],
            'secondary_button_text_ar' => ['nullable', 'string'],
            'secondary_button_link' => ['nullable', 'string', 'max:2048'],
            'trusted_badge_en' => ['required', 'string'],
            'trusted_badge_ar' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'statistics' => ['nullable', 'array'],
            'statistics.*.id' => ['nullable', 'integer'],
            'statistics.*.value' => ['nullable', 'string'],
            'statistics.*.label_en' => ['nullable', 'string'],
            'statistics.*.label_ar' => ['nullable', 'string'],
        ];
    }

    private function packagesRules(): array
    {
        return $this->baseSectionRules() + [
            'popular_badge_en' => ['required', 'string'],
            'popular_badge_ar' => ['required', 'string'],
            'billing_period_en' => ['required', 'string'],
            'billing_period_ar' => ['required', 'string'],
            'packages' => ['nullable', 'array'],
            'packages.*.id' => ['nullable', 'integer'],
            'packages.*.name_en' => ['nullable', 'string'],
            'packages.*.name_ar' => ['nullable', 'string'],
            'packages.*.users_en' => ['nullable', 'string'],
            'packages.*.users_ar' => ['nullable', 'string'],
            'packages.*.description_en' => ['nullable', 'string'],
            'packages.*.description_ar' => ['nullable', 'string'],
            'packages.*.price' => ['nullable', 'numeric', 'min:0'],
            'packages.*.button_text_en' => ['nullable', 'string'],
            'packages.*.button_text_ar' => ['nullable', 'string'],
            'packages.*.is_popular' => ['nullable', 'boolean'],
            'packages.*.features_text' => ['nullable', 'string'],
        ];
    }

    private function socialProofRules(): array
    {
        return $this->baseSectionRules() + [
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.company' => ['nullable', 'string'],
            'items.*.metric' => ['nullable', 'string'],
            'items.*.quote_en' => ['nullable', 'string'],
            'items.*.quote_ar' => ['nullable', 'string'],
        ];
    }

    private function howItWorksRules(): array
    {
        return $this->sectionWithItemsRules('steps') + [
            'cta_title_en' => ['nullable', 'string'],
            'cta_title_ar' => ['nullable', 'string'],
            'cta_description_en' => ['nullable', 'string'],
            'cta_description_ar' => ['nullable', 'string'],
            'cta_button_text_en' => ['nullable', 'string'],
            'cta_button_text_ar' => ['nullable', 'string'],
            'cta_button_link' => ['nullable', 'string', 'max:2048'],
            'cta_secondary_button_text_en' => ['nullable', 'string'],
            'cta_secondary_button_text_ar' => ['nullable', 'string'],
            'cta_secondary_button_link' => ['nullable', 'string', 'max:2048'],
        ];
    }

    private function comparisonRules(): array
    {
        return $this->baseSectionRules() + [
            'before_title_en' => ['nullable', 'string'],
            'before_title_ar' => ['nullable', 'string'],
            'before_subtitle_en' => ['nullable', 'string'],
            'before_subtitle_ar' => ['nullable', 'string'],
            'after_title_en' => ['nullable', 'string'],
            'after_title_ar' => ['nullable', 'string'],
            'after_subtitle_en' => ['nullable', 'string'],
            'after_subtitle_ar' => ['nullable', 'string'],
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.icon' => ['nullable', 'string'],
            'items.*.text_en' => ['nullable', 'string'],
            'items.*.text_ar' => ['nullable', 'string'],
            'items.*.color' => ['nullable', 'string', 'in:red,green'],
        ];
    }

    private function faqRules(): array
    {
        return $this->baseSectionRules() + [
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.question_en' => ['nullable', 'string'],
            'items.*.question_ar' => ['nullable', 'string'],
            'items.*.answer_en' => ['nullable', 'string'],
            'items.*.answer_ar' => ['nullable', 'string'],
        ];
    }

    private function contactRules(): array
    {
        return $this->baseSectionRules() + [
            'form_title_en' => ['nullable', 'string'],
            'form_title_ar' => ['nullable', 'string'],
            'form_description_en' => ['nullable', 'string'],
            'form_description_ar' => ['nullable', 'string'],
            'form_button_text_en' => ['nullable', 'string'],
            'form_button_text_ar' => ['nullable', 'string'],
            'form_success_text_en' => ['nullable', 'string'],
            'form_success_text_ar' => ['nullable', 'string'],
            'form_error_text_en' => ['nullable', 'string'],
            'form_error_text_ar' => ['nullable', 'string'],
            'form_sending_text_en' => ['nullable', 'string'],
            'form_sending_text_ar' => ['nullable', 'string'],
            'form_name_label_en' => ['nullable', 'string'],
            'form_name_label_ar' => ['nullable', 'string'],
            'form_name_placeholder_en' => ['nullable', 'string'],
            'form_name_placeholder_ar' => ['nullable', 'string'],
            'form_email_label_en' => ['nullable', 'string'],
            'form_email_label_ar' => ['nullable', 'string'],
            'form_email_placeholder_en' => ['nullable', 'string'],
            'form_email_placeholder_ar' => ['nullable', 'string'],
            'form_company_label_en' => ['nullable', 'string'],
            'form_company_label_ar' => ['nullable', 'string'],
            'form_company_placeholder_en' => ['nullable', 'string'],
            'form_company_placeholder_ar' => ['nullable', 'string'],
            'form_badges_text' => ['nullable', 'string'],
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.icon' => ['nullable', 'string'],
            'items.*.label_en' => ['nullable', 'string'],
            'items.*.label_ar' => ['nullable', 'string'],
            'items.*.value' => ['nullable', 'string'],
        ];
    }

    private function footerRules(): array
    {
        return [
            'description_en' => ['required', 'string'],
            'description_ar' => ['required', 'string'],
            'copyright_en' => ['required', 'string'],
            'copyright_ar' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'link_groups' => ['nullable', 'array'],
            'link_groups.*.id' => ['nullable', 'integer'],
            'link_groups.*.key' => ['nullable', 'string'],
            'link_groups.*.title_en' => ['nullable', 'string'],
            'link_groups.*.title_ar' => ['nullable', 'string'],
            'link_groups.*.links' => ['nullable', 'array'],
            'link_groups.*.links.*.id' => ['nullable', 'integer'],
            'link_groups.*.links.*.label_en' => ['nullable', 'string'],
            'link_groups.*.links.*.label_ar' => ['nullable', 'string'],
            'link_groups.*.links.*.url' => ['nullable', 'string', 'max:2048'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.id' => ['nullable', 'integer'],
            'social_links.*.platform' => ['nullable', 'string', 'in:facebook,linkedin,instagram,tiktok'],
            'social_links.*.url' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
