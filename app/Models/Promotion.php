<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'code',
        'discount_amount',
        'discount_percentage',
        'minimum_spend',
        'start_date',
        'end_date',
        'active',
        'bg_image',
    ];
}
