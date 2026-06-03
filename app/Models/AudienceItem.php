<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudienceItem extends Model
{
    protected $fillable = ['target_audience_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'icon', 'order'];

    public function targetAudience(): BelongsTo
    {
        return $this->belongsTo(TargetAudience::class);
    }
}
