<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComparisonItem extends Model
{
    protected $fillable = ['comparison_section_id', 'icon', 'text_en', 'text_ar', 'color', 'order'];

    public function comparisonSection(): BelongsTo
    {
        return $this->belongsTo(ComparisonSection::class);
    }
}
