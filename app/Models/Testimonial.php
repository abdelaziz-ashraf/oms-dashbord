<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_name_en', 'client_name_ar', 'client_title_en',
        'client_title_ar', 'company', 'quote_en', 'quote_ar', 'rating',
        'image_path', 'is_featured', 'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'integer',
        ];
    }
}
