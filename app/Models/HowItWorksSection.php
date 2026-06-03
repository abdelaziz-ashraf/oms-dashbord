<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HowItWorksSection extends Model
{
    protected $fillable = [
        'landing_page_id',
        'eyebrow_en',
        'eyebrow_ar',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'cta_title_en',
        'cta_title_ar',
        'cta_description_en',
        'cta_description_ar',
        'cta_button_text_en',
        'cta_button_text_ar',
        'cta_button_link',
        'cta_secondary_button_text_en',
        'cta_secondary_button_text_ar',
        'cta_secondary_button_link',
        'is_active',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(HowItWorksStep::class)->orderBy('order');
    }
}
