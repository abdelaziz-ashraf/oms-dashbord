<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhyUsItem extends Model
{
    protected $fillable = ['why_us_section_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'icon', 'order'];

    public function whyUsSection(): BelongsTo
    {
        return $this->belongsTo(WhyUsSection::class);
    }
}
