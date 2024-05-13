<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecommerce extends Model
{
    use HasFactory;

    protected $fillable = [
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

    // Business Types
    const B2C = 'B2C';
    const B2B = 'B2B';
    const B2B_PLUS = 'B2B Plus';

    // Product Stock Display Options
    const TEXT_ONLY = 'Text Only';
    const TEXT_AND_QUANTITY = 'Text + Quantity';
    const DO_NOT_DISPLAY = 'Do not display';

    // Registration Process Options
    const OPTIONAL = 'Optional';
    const MANDATORY = 'Mandatory';
    const MANDATORY_WITH_CONFIRMATION = 'Mandatory with confirmation';

    // Offer Display Options
    const VIEW_CUT_PRICE = 'View cut price';
    const DO_NOT_DISPLAY_CUT_PRICE = 'Do not display the cut price';

    // Accepted Payments
    const PAYPAL = 'PayPal';
    const BANK_TRANSFER = 'Bank Transfer';
    const CASH_ON_DELIVERY = 'Cash on Delivery';
    const COLLECTION_AND_PAYMENT_ON_SITE = 'Collection and payment on site';

    public static $businessTypes = [
        self::B2C,
        self::B2B,
        self::B2B_PLUS,
    ];

    public static $productStockDisplayOptions = [
        self::TEXT_ONLY,
        self::TEXT_AND_QUANTITY,
        self::DO_NOT_DISPLAY,
    ];

    public static $registrationProcessOptions = [
        self::OPTIONAL,
        self::MANDATORY,
        self::MANDATORY_WITH_CONFIRMATION,
    ];

    public static $offerDisplayOptions = [
        self::VIEW_CUT_PRICE,
        self::DO_NOT_DISPLAY_CUT_PRICE,
    ];

    public static $acceptedPayments = [
        self::PAYPAL,
        self::BANK_TRANSFER,
        self::CASH_ON_DELIVERY,
        self::COLLECTION_AND_PAYMENT_ON_SITE,
    ];

    protected $casts = [
        'price_with_vat' => 'boolean',
        'size_color_options' => 'boolean',
    ];
}
