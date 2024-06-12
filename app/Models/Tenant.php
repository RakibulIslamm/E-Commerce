<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'business_name',
            'domain',
            'auth_username',
            'auth_password',
            'email',
            'tax_code',
            'phone',
            'rest_api_user',
            'rest_api_password',
            'business_type',
            'price_with_vat',
            'decimal_places',
            'size_color_options',
            'product_stock_display',
            'registration_process',
            'accepted_payments',
            'offer_display',
        ];
    }
    protected $casts = [
        'accepted_payments' => 'json',
    ];


    public function setPasswordAttribute($value)
    {
        return $this->attributes['auth_password'] = bcrypt($value);
    }

    public function primaryDomain()
    {
        return $this->hasOne(Domain::class)->where('is_primary', true);
    }
}
