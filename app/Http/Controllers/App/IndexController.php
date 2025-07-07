<?php

namespace App\Http\Controllers\App;

use App\Models\Category;
use App\Models\ContentSlider;
use App\Models\News;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController
{

    public function index(Request $request)
    {
        $show_out_of_stock = tenant()?->show_out_of_stock;

        $start = microtime(true);
        $sliders = ContentSlider::orderBy('position')->get();
        Log::info('Query sliders durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        $news = News::orderBy('created_at', 'desc')->take(6)->get();
        Log::info('Query news durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        $newArrivals = Product::where('NOVITA', true)
            ->when(!$show_out_of_stock, function ($query) {
                $query->where('giacenza', '>', 0);
            })
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        Log::info('Query newArrivals durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        $bestSellers = Product::where('PIUVENDUTI', true)
            ->when(!$show_out_of_stock, function ($query) {
                $query->where('giacenza', '>', 0);
            })
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        Log::info('Query bestSellers durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        foreach ($newArrivals as $product) {
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0] : null;
            }
        }
        Log::info('Decoding FOTO newArrivals durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        foreach ($bestSellers as $product) {
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0] : null;
            }
        }
        Log::info('Decoding FOTO bestSellers durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        $categories = Category::usedInProducts()->orderBy('nome')->get();
        Log::info('Query categories durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        $start = microtime(true);
        $promotion = Promotion::where('active', true)->first();
        Log::info('Query promotion durata: ' . round(microtime(true) - $start, 3) . ' secondi');

        return view("app.pages.index", [
            'sliders' => $sliders,
            'newArrivals' => $newArrivals,
            'bestSellers' => $bestSellers,
            'categories_home' => $categories,
            'promotion' => $promotion,
            'news'=> $news,
        ]);
    }

}
