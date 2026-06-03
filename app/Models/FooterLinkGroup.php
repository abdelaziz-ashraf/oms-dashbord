<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
