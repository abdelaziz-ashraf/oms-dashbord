<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'title_en', 'title_ar', 'summary_en', 'summary_ar',
        'description_en', 'description_ar', 'icon', 'is_featured',
        'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
