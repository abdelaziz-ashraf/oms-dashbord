<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackagesSection extends Model
{
    protected $fillable = ['landing_page_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'popular_badge_en', 'popular_badge_ar', 'billing_period_en', 'billing_period_ar', 'is_active'];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class)->orderBy('order');
    }
}

class Package extends Model
{
    protected $fillable = ['packages_section_id', 'name_en', 'name_ar', 'users_en', 'users_ar', 'description_en', 'description_ar', 'price', 'button_text_en', 'button_text_ar', 'order'];

    public function packagesSection(): BelongsTo
    {
        return $this->belongsTo(PackagesSection::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class)->orderBy('order');
    }
}

class PackageFeature extends Model
{
    protected $fillable = ['package_id', 'name_en', 'name_ar', 'order'];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}