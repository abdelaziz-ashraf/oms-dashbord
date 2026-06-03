<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FooterLink extends Model
{
    protected $fillable = ['footer_link_group_id', 'label_en', 'label_ar', 'url', 'order'];

    public function footerLinkGroup(): BelongsTo
    {
        return $this->belongsTo(FooterLinkGroup::class);
    }
}
