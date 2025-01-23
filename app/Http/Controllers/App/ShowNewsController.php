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
        
        // Retrieve paginated news items, e.g., 10 per page
        $news = News::paginate(10); // Adjust the number as needed

        return view("app.pages.news.index", [
            "news" => $news,
            "breadcrumbs" => $breadcrumbs
        ]);
    }


    public function show(News $news)
    {
        $breadcrumbs = Breadcrumbs::generate('newsDetail', $news);
        $relatedNews = News::where('id', '!=', $news->id)->latest()->take(3)->get();

        // Return the view with the necessary data
        return view('app.pages.news.show', [
            'newsItem' => $news,
            'relatedNews' => $relatedNews,
            'breadcrumbs' => $breadcrumbs
        ]);

    }
}
