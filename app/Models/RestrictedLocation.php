<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestrictedLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'postal_code'
    ];
}
