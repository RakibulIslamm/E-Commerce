<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
        $allCodes = Cache::remember('products_category_codes', 3600, function () {
            $products = \DB::table('products')
                ->whereNotNull('CATEGORIEESOTTOCATEGORIE')
                ->pluck('CATEGORIEESOTTOCATEGORIE');

            return $products
                ->flatMap(fn($json) => json_decode($json, true) ?? [])
                ->unique()
                ->values();
        });

        return $query->whereIn('codice', $allCodes);
    }
}
