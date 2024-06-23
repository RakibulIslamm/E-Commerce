<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingData extends Model
{
    use HasFactory;
    protected $fillable = [
        'courier',
        'minimum_spend',
        'marking_costs',
        'vat_value',
        'shipping_italy_until',
        'shipping_italy_charge',
        'shipping_major_islands_until',
        'shipping_major_islands_charge',
        'shipping_smaller_islands_until',
        'shipping_smaller_islands_charge',
    ];
}
