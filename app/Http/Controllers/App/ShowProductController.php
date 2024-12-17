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

        // Filter by category
        if (request()->filled('category')) {
            $query->where('CATEGORIEESOTTOCATEGORIE', request()->category);
        }

        // Order by specified column or default to created_at
        if (request()->filled('order_by') && (request()->order_by == 'asc' || request()->order_by == 'desc')) {
            $query->orderBy('DESCRIZIONEBREVE', request()->order_by);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        if(request()->filled('q')){
            if(request()->q == 'new'){
                $query->where('NOVITA', true);
            }
            else if(request()->q == 'best_seller'){
                $query->where('PIUVENDUTI', true);
            }
        }

        // Apply search filter if provided
        if (request()->filled('search')) {
            $searchTerm = request()->search;
            $query->where('DESCRIZIONEBREVE', 'LIKE', '%' . $searchTerm . '%');
        }

        // Filter by best sellers or new arrivals
        if (request()->filled('best') && request()->best == 1) {
            $query->where('PIUVENDUTI', true);
        } elseif (request()->filled('new') && request()->new_arrivals == 1) {
            $query->where('NOVITA', true);
        }

        // Set the number of items per page, default to 10 if not provided
        $perPage = request()->input('limit', 12);

        // Get paginated results
        $products = $query->paginate($perPage);

        // Append query parameters to the pagination links
        $products->appends(request()->all());


        // dd($products->links());

        // Process product images
        foreach ($products as $product) {
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0]:null;
            }
        }

        return view("app.pages.products.index", [
            "products" => $products,
            "breadcrumbs" => $products_breadcrumbs
        ]);
    }

    public function show(Product $product)
    {
        $product_breadcrumbs = Breadcrumbs::generate('product', $product);
        $product['FOTO'] = json_decode($product['FOTO'], true);
        return view("app.pages.products.show", ["product" => $product, "breadcrumbs" => $product_breadcrumbs]);
    }
}
