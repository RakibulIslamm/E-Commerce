<?php

namespace App\Http\Controllers\App;

use App\Models\Product;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

// $products = Product::whereHas('category', function ($query) use ($categoryId) {
//     $query->where('id', $categoryId);
// })->get();
class ShowProductController
{
    public function index()
    {
        $products_breadcrumbs = Breadcrumbs::generate('products');
        $query = Product::query();
        if (request()->filled('category')) {
            $query->where('CATEGORIEESOTTOCATEGORIE', request()->category);
        }

        if (request()->filled('order_by') && (request()->order_by == 'acs' || request()->order_by == 'desc')) {
            $query->orderBy('DESCRIZIONEBREVE', request()->order_by);
        }

        if (request()->filled('best') && request()->best == 1) {
            $query->where('PIUVENDUTI', true);
        } elseif (request()->filled('new') && request()->new_arrivals == 1) {
            $query->where('NOVITA', true);
        }

        $products = $query->get();

        // dd($products);

        return view("app.pages.products.index", ["products" => $products, "breadcrumbs" => $products_breadcrumbs]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        // dd($product);
        return view("app.pages.products.show", ["product" => $product]);
    }
}
