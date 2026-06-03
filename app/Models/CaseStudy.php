<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseStudy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'slug', 'title_en', 'title_ar', 'client_name',
        'summary_en', 'summary_ar', 'challenge_en', 'challenge_ar',
        'solution_en', 'solution_ar', 'results_en', 'results_ar',
        'published_at', 'is_featured', 'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
