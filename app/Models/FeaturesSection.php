<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeaturesSection extends Model
{
    protected $fillable = ['landing_page_id', 'eyebrow_en', 'eyebrow_ar', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class)->orderBy('order');
    }
}
