<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
        'estimated_hours',
        'actual_hours'
    ];

    public function project()
    {
        return $this->belongsTo(Quote::class, 'project_id');
    }
}
