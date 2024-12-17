<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    use HasFactory;
    
    protected $fillable = ['courier', 'minimum_order', 'cod_fee', 'vat_rate'];

    public function rules()
    {
        return $this->hasMany(ShippingRule::class);
    }
}
