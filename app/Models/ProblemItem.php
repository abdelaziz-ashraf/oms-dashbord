<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProblemItem extends Model
{
    protected $fillable = ['problem_section_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'icon', 'order'];

    public function problemSection(): BelongsTo
    {
        return $this->belongsTo(ProblemSection::class);
    }
}
