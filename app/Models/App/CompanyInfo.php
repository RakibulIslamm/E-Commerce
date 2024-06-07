<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img',
        'logo_height',
        'description',
        'industry',
        'founded',
        'email',
        'phone',
        'address',
        'social_media',
        'tenant_id'
    ];
}
