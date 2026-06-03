<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeroSection extends Model
{
    protected $fillable = [
        'landing_page_id', 'title_en', 'title_ar', 'subtitle_en', 'subtitle_ar',
        'button_text_en', 'button_text_ar', 'button_link',
        'secondary_button_text_en', 'secondary_button_text_ar', 'secondary_button_link',
        'trusted_badge_en', 'trusted_badge_ar', 'is_active'
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(HeroStatistic::class)->orderBy('order');
    }
}
