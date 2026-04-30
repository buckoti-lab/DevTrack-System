<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'quote_id',
        'title',
        'status'
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
    // public function quote()
    // {
    //     return $this->belongsTo(Quote::class,'quote_id');
    // }

    // public function tasks()
    // {
    //     return $this->hasMany(Task::class);
    // }
}
