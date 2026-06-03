<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    protected $fillable = ['footer_section_id', 'platform', 'url', 'order'];

    public function footerSection(): BelongsTo
    {
        return $this->belongsTo(FooterSection::class);
    }
}
