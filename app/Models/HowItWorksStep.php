<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HowItWorksStep extends Model
{
    protected $fillable = ['how_it_works_section_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'order'];

    public function howItWorksSection(): BelongsTo
    {
        return $this->belongsTo(HowItWorksSection::class);
    }
}
