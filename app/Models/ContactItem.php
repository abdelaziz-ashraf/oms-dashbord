<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactItem extends Model
{
    protected $fillable = ['contact_section_id', 'icon', 'label_en', 'label_ar', 'value', 'order'];

    public function contactSection(): BelongsTo
    {
        return $this->belongsTo(ContactSection::class);
    }
}
