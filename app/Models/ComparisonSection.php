<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComparisonSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ComparisonItem::class)->orderBy('order');
    }
}

class ComparisonItem extends Model
{
    protected $fillable = ['comparison_section_id', 'icon', 'text_en', 'text_ar', 'color', 'order'];

    public function comparisonSection(): BelongsTo
    {
        return $this->belongsTo(ComparisonSection::class);
    }
}