<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_id',
        'postal_code'
    ];

    // Define relationship to Location model
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
