<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'BARCODE',
        'DESCRIZIONEBREVE',
        'DESCRIZIONEESTESA',
        'ALIQUOTAIVA',
        'UNITAMISURA',
        'PXC',
        'CODICELEGAME',
        'MARCA',
        'CATEGORIEESOTTOCATEGORIE',
        'GIACENZA',
        'ARTICOLIALTERNATIVI',
        'ARTICOLICORRELATI',
        'NOVITA',
        'PIUVENDUTI',
        'VISIBILE',
        'FOTO',
        'PESOARTICOLO',
        'TAGLIA',
        'COLORE',
        'PRE1IMP',
        'PRE1IVA',
        'PRE2IMP',
        'PRE2IVA',
        'PRE3IMP',
        'PRE3IVA',
        'PREPROMOIMP',
        'PREPROMOIVA',
        'DATAINIZIOPROMO',
        'DATAFINEPROMO',
    ];

    protected $casts = [
        'FOTO' => 'array',
        'NOVITA' => 'boolean',
        'PIUVENDUTI' => 'boolean',
        'VISIBILE' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CATEGORIEESOTTOCATEGORIE');
    }
}
