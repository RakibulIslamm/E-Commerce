<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'n_ordine',
        'user_id',
        'nominativo',
        'promotion_id',
        'ragione_sociale',
        'indirizzo',
        'cap',
        'citta',
        'provincia',
        'email',
        'telefono',
        'stato',
        'pagato',
        'totale_netto',
        'totale_iva',
        'spese_spedizione',
        'nominativo_spedizione',
        'ragione_sociale_spedizione',
        'indirizzo_spedizione',
        'cap_spedizione',
        'citta_spedizione',
        'provincia_spedizione',
        'spedizione',
        'note',
        'corriere',
        'nuovi',
        'cod_fee'
    ];

    public function articoli()
    {
        return $this->hasMany(OrderItem::class);
    }
}
