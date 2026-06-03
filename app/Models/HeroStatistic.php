<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroStatistic extends Model
{
    protected $fillable = ['hero_section_id', 'value', 'label_en', 'label_ar', 'order'];

    public function heroSection(): BelongsTo
    {
        return $this->belongsTo(HeroSection::class);
    }
}
