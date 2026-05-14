<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HowItWorksSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(HowItWorksStep::class)->orderBy('order');
    }
}

class HowItWorksStep extends Model
{
    protected $fillable = ['how_it_works_section_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'order'];

    public function howItWorksSection(): BelongsTo
    {
        return $this->belongsTo(HowItWorksSection::class);
    }
}