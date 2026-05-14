<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ContactItem::class)->orderBy('order');
    }
}

class ContactItem extends Model
{
    protected $fillable = ['contact_section_id', 'icon', 'label_en', 'label_ar', 'value', 'order'];

    public function contactSection(): BelongsTo
    {
        return $this->belongsTo(ContactSection::class);
    }
}