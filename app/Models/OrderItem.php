<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product',
        'qta',
        'imponibile',
        'ivato'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
