<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'title_en', 'title_ar', 'excerpt_en', 'excerpt_ar',
        'body_en', 'body_ar', 'cover_image_path', 'author_name',
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
}
