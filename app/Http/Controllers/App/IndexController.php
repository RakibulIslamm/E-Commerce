<?php

namespace App\Http\Controllers\App;

use App\Models\Category;
use App\Models\ContentSlider;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        $sliders = ContentSlider::orderBy('position')->get();
        $products = Product::all();

        foreach ($products as $product) {
            $product['FOTO'] = json_decode($product['FOTO'], true);
            if (isset($product['FOTO'])) {
                $product['FOTO'] = $product->FOTO[0];
            }
        }

        // dd($products);

        $categories = Category::all();
        return view("app.pages.index", ['sliders' => $sliders, 'products' => $products, 'categories' => $categories]);
    }
}
