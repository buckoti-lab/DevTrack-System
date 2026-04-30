<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    //
    protected  $fillable = [
        "description",
        "type",
        "uploaded_by",
        "updated_by",
        "project_id",
        "filename"
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
