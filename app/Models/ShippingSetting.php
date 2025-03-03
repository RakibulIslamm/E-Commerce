<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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

    public static function getValidShippingSettings(float $totalPrice): Collection
    {
        // Get the shipping settings along with the rules
        $shippingSettings = self::with('rules')
            ->orderBy('minimum_order', 'asc')
            ->get();

        if ($shippingSettings->isEmpty()) {
            return collect();
        }

        // Return the valid shipping settings
        return $shippingSettings->filter(function ($setting) use ($totalPrice) {
            return $setting->minimum_order <= $totalPrice;
        });
    }
}
