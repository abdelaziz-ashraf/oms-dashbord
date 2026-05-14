<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TargetAudience extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(AudienceItem::class)->orderBy('order');
    }
}

class AudienceItem extends Model
{
    protected $fillable = ['target_audience_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'icon', 'order'];

    public function targetAudience(): BelongsTo
    {
        return $this->belongsTo(TargetAudience::class);
    }
}