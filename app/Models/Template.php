<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Template extends Model
{
    protected $casts = [
        'id' => 'int',
        'subject' => 'string',
        'fallback_to' => 'array',
        'fallback_cc' => 'array',
        'fallback_bcc' => 'array',
        'fallback_return_path' => 'string',
        'fallback_reply_to' => 'string',
        'is_published' => 'boolean',
        'content' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'name',
        'subject',
        'fallback_to',
        'fallback_cc',
        'fallback_bcc',
        'fallback_return_path',
        'fallback_reply_to',
        'is_published',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
