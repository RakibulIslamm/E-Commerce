<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'n_ordine',
        'data_ordine',
        'promo',
        'nominativo',
        'ragione_sociale',
        'indirizzo',
        'cap',
        'citta',
        'provincia',
        'email',
        'telefono',
        'stato',
        'pagamento',
        'totale_netto',
        'totale_iva',
        'promo_netto',
        'promo_iva',
        'spese_spedizione',
        'nominativo_spedizione',
        'ragione_sociale_spedizione',
        'indirizzo_spedizione',
        'cap_spedizione',
        'citta_spedizione',
        'provincia_spedizione',
        'pec',
        'sdi',
        'note',
        'corriere',
        'downloaded'
    ];

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
