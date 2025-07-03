<?php

namespace App\Http\Controllers\App;

use App\Models\Category;
use App\Models\ContentSlider;
use App\Models\News;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        $show_out_of_stock = tenant()?->show_out_of_stock;

        $sliders = ContentSlider::orderBy('position')->get();
        $news = News::orderBy('created_at', 'desc')->take(6)->get();
        
        // Fetch New Arrivals (limit 8)
        $newArrivals = Product::where('NOVITA', true)
            ->when(!$show_out_of_stock, function ($query) {
                $query->where('giacenza', '>', 0);
            })
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Fetch Best Sellers (limit 8)
        $bestSellers = Product::where('PIUVENDUTI', true)
            ->when(!$show_out_of_stock, function ($query) {
                $query->where('giacenza', '>', 0);
            })
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Decode FOTO field for New Arrivals
        foreach ($newArrivals as $product) {
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0]:null;
            }
        }

        // Decode FOTO field for Best Sellers
        foreach ($bestSellers as $product) {
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0]:null;
            }
        }

        $categories = Category::usedInProducts()->orderBy('nome')->get();

        $promotion = Promotion::where('active', true)->first();

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
