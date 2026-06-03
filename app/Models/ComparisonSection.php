<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComparisonSection extends Model
{
    protected $fillable = [
        'landing_page_id',
        'eyebrow_en',
        'eyebrow_ar',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'before_title_en',
        'before_title_ar',
        'before_subtitle_en',
        'before_subtitle_ar',
        'after_title_en',
        'after_title_ar',
        'after_subtitle_en',
        'after_subtitle_ar',
        'is_active',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ComparisonItem::class)->orderBy('order');
    }
}
