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
        // Recupera tutti i codici categoria distinti direttamente dal DB con JSON_SEARCH o JSON_CONTAINS
        // Nota: serve versione MySQL >= 5.7 che supporti JSON_EXTRACT

        // Prima, estrai tutti i codici distinti direttamente con query raw

        $allCodes = DB::table('products')
            ->select(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(CATEGORIEESOTTOCATEGORIE, CONCAT('$[', n.n, ']'))) AS codice"))
            ->crossJoin(DB::raw("(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) n"))
            ->whereNotNull('CATEGORIEESOTTOCATEGORIE')
            ->groupBy('codice')
            ->pluck('codice');

        // Ora filtriamo solo codici validi e non null
        $allCodes = $allCodes->filter()->unique()->values();

        return $query->whereIn('codice', $allCodes);
    }
}
