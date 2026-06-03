<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = ['packages_section_id', 'name_en', 'name_ar', 'users_en', 'users_ar', 'description_en', 'description_ar', 'price', 'button_text_en', 'button_text_ar', 'is_popular', 'order'];

    protected $casts = [
        'is_popular' => 'boolean',
    ];

    public function packagesSection(): BelongsTo
    {
        return $this->belongsTo(PackagesSection::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class)->orderBy('order');
    }
}
