<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtaSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'button_text_en', 'button_text_ar', 'button_link', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}