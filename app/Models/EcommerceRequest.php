<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        "domain",
        "user_id",
        "business_type",
        "vat_number",
        "email",
        "company_name",
    ];

    // Business Types
    const B2C = 'B2C';
    const B2B = 'B2B';
    const B2B_PLUS = 'B2B Plus';

    public static $businessTypes = [
        self::B2C,
        self::B2B,
        self::B2B_PLUS,
    ];
}
