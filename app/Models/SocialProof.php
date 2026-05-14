<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialProof extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SocialProofItem::class)->orderBy('order');
    }
}

class SocialProofItem extends Model
{
    protected $fillable = ['social_proof_id', 'company', 'metric', 'quote_en', 'quote_ar', 'order'];

    public function socialProof(): BelongsTo
    {
        return $this->belongsTo(SocialProof::class);
    }
}