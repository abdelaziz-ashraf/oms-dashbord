<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(FaqItem::class)->orderBy('order');
    }
}

class FaqItem extends Model
{
    protected $fillable = ['faq_section_id', 'question_en', 'question_ar', 'answer_en', 'answer_ar', 'order'];

    public function faqSection(): BelongsTo
    {
        return $this->belongsTo(FaqSection::class);
    }
}