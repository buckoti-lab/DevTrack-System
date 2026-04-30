<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'target',
        'content',
        'expires_at',
        'updated_by',
        'created_by',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];
}

