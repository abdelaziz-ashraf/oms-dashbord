<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioSection extends Model
{
    protected $fillable = [
        'module',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'is_active',
        'order',
        'limit',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'limit' => 'integer',
    ];
}
