<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'uploaded_by',
        'name',
        'type',
        'description',
        'filename',
        'updated_by'
    ];
    
    
}
