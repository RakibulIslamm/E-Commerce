<?php

namespace App\Http\Controllers\App;

use App\Models\Category;
use App\Models\ContentSlider;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        $sliders = ContentSlider::orderBy('position')->get();

        // Fetch New Arrivals (limit 8)
        $newArrivals = Product::where('NOVITA', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Fetch Best Sellers (limit 8)
        $bestSellers = Product::where('PIUVENDUTI', true)
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
            $product['FOTO'] = json_decode($product['FOTO'], true);
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0]:null;
            }
        }

        $categories = Category::all();
        $promotion = Promotion::where('active', true)->first();

        return view("app.pages.index", [
            'sliders' => $sliders,
            'newArrivals' => $newArrivals,
            'bestSellers' => $bestSellers,
            'categories' => $categories,
            'promotion' => $promotion,
        ]);
    }
}
