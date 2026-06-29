<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'company',
        'industry',
        'job_title',
        'company_size',
        'improvements',
        'subject',
        'message',
        'locale',
        'source',
        'status',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'improvements' => 'array',
            'read_at' => 'datetime',
        ];
    }
}
