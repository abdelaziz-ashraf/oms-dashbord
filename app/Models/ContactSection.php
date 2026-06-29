<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactSection extends Model
{
    protected $fillable = [
        'landing_page_id',
        'eyebrow_en',
        'eyebrow_ar',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'form_title_en',
        'form_title_ar',
        'form_description_en',
        'form_description_ar',
        'form_button_text_en',
        'form_button_text_ar',
        'form_success_text_en',
        'form_success_text_ar',
        'form_error_text_en',
        'form_error_text_ar',
        'form_sending_text_en',
        'form_sending_text_ar',
        'form_name_label_en',
        'form_name_label_ar',
        'form_name_placeholder_en',
        'form_name_placeholder_ar',
        'form_email_label_en',
        'form_email_label_ar',
        'form_email_placeholder_en',
        'form_email_placeholder_ar',
        'form_company_label_en',
        'form_company_label_ar',
        'form_company_placeholder_en',
        'form_company_placeholder_ar',
        'form_badges',
        'is_active',
        'whatsapp_number',
    ];

    protected $casts = [
        'form_badges' => 'array',
        'is_active' => 'boolean',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ContactItem::class)->orderBy('order');
    }
}
