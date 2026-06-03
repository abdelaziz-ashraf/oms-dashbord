<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialProofItem extends Model
{
    protected $fillable = ['social_proof_id', 'company', 'metric', 'quote_en', 'quote_ar', 'order'];

    public function socialProof(): BelongsTo
    {
        return $this->belongsTo(SocialProof::class);
    }
}
