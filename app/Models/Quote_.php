<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_email',
        'company_contact',
        'company_date',
        'company_website',
        'client_name',
        'client_address',
        'client_email',
        'client_contact',
        'quote_number',
        'quote_valid_date',
        'items',
        'sub_total',
        'tax',
        'discount',
        'grand_total'
    ];

    protected $casts = [
        'items' => 'array',
        'company_date' => 'date',
        'quote_valid_date' => 'date',
    ];
}
