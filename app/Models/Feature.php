<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    protected $fillable = ['features_section_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'icon', 'order'];

    public function featuresSection(): BelongsTo
    {
        return $this->belongsTo(FeaturesSection::class);
    }
}
