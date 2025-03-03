<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'cod_fee',
        'piva',
        'cf'
    ];

    public function articoli()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function articoliFormatted(): Attribute
    {
        return Attribute::get(function () {
            return $this->articoli->map(function ($item) {
                return "{$item->id}|{$item->qta}|{$item->imponibile}|{$item->ivato}";
            })->toArray();
        });
    }
}
