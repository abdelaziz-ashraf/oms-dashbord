<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqItem extends Model
{
    protected $fillable = ['faq_section_id', 'question_en', 'question_ar', 'answer_en', 'answer_ar', 'order'];

    public function faqSection(): BelongsTo
    {
        return $this->belongsTo(FaqSection::class);
    }
}
