<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    use HasFactory;

    protected $fillable = ['shipping_setting_id', 'zone', 'threshold', 'fee'];

    public function shippingSetting()
    {
        return $this->belongsTo(ShippingSetting::class);
    }
}
