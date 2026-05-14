<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProblemSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProblemItem::class)->orderBy('order');
    }
}

class ProblemItem extends Model
{
    protected $fillable = ['problem_section_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'icon', 'order'];

    public function problemSection(): BelongsTo
    {
        return $this->belongsTo(ProblemSection::class);
    }
}