<?php

namespace App\Http\Controllers\App;

use App\Models\News;
use App\Models\Product;
use Diglactic\Breadcrumbs\Breadcrumbs;

// $products = Product::whereHas('category', function ($query) use ($categoryId) {
//     $query->where('id', $categoryId);
// })->get();
class ShowNewsController
{
    public function index()
    {

        $breadcrumbs = Breadcrumbs::generate('news');
        $news = News::all();
        // dd($breadcrumbs);
        return view("app.pages.news.index", ["news" => $news, "breadcrumbs" => $breadcrumbs]);
    }

    public function show(News $news)
    {

    }
}
