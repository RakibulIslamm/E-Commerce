<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'codice',
        'nome',
        'img',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    // public function children()
    // {
    //     return $this->hasMany(Category::class, 'codice', 'codice');
    // }

    // public function parent()
    // {
    //     return $this->belongsTo(Category::class, 'codice', 'codice');
    // }

    public function scopeUsedInProducts($query)
    {
        // Get all products with non-null categories
        $products = DB::table('products')
            ->whereNotNull('CATEGORIEESOTTOCATEGORIE')
            ->pluck('CATEGORIEESOTTOCATEGORIE');

        // Decode all JSON category arrays and flatten them
        $allCodes = $products
            ->flatMap(function ($json) {
                return json_decode($json, true) ?? [];
            })
            ->unique()
            ->values();

        return $query->whereIn('codice', $allCodes);
    }
}
