<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterSection extends Model
{
    protected $fillable = ['landing_page_id', 'description_en', 'description_ar', 'copyright_en', 'copyright_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function linkGroups(): HasMany
    {
        return $this->hasMany(FooterLinkGroup::class)->orderBy('order');
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('order');
    }
}

class FooterLinkGroup extends Model
{
    protected $fillable = ['footer_section_id', 'key', 'title_en', 'title_ar', 'order'];

    public function footerSection(): BelongsTo
    {
        return $this->belongsTo(FooterSection::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)->orderBy('order');
    }
}

class FooterLink extends Model
{
    protected $fillable = ['footer_link_group_id', 'label_en', 'label_ar', 'url', 'order'];

    public function footerLinkGroup(): BelongsTo
    {
        return $this->belongsTo(FooterLinkGroup::class);
    }
}

class SocialLink extends Model
{
    protected $fillable = ['footer_section_id', 'platform', 'url', 'order'];

    public function footerSection(): BelongsTo
    {
        return $this->belongsTo(FooterSection::class);
    }
}