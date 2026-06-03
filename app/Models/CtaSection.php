<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtaSection extends Model
{
    protected $fillable = [
        'landing_page_id',
        'eyebrow_en',
        'eyebrow_ar',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'button_text_en',
        'button_text_ar',
        'button_link',
        'secondary_button_text_en',
        'secondary_button_text_ar',
        'secondary_button_link',
        'whatsapp_number',
        'badges',
        'is_active',
    ];

    protected $casts = [
        'badges' => 'array',
        'is_active' => 'boolean',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
