<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackagesSection extends Model
{
    protected $fillable = ['landing_page_id', 'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar', 'popular_badge_en', 'popular_badge_ar', 'billing_period_en', 'billing_period_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class)->orderBy('order');
    }
}
