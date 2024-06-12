<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSlider extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'link', 'link_text', 'title', 'description', 'img', 'position'];

}
