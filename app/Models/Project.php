<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'title_en', 'title_ar', 'client_name', 'industry_en',
        'industry_ar', 'summary_en', 'summary_ar', 'description_en',
        'description_ar', 'results_en', 'results_ar', 'project_url',
        'image_path', 'is_featured', 'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function caseStudies(): HasMany
    {
        return $this->hasMany(CaseStudy::class);
    }
}
