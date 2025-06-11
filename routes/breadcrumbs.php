<?php

// routes/breadcrumbs.php

use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('app.dashboard'));
});

Breadcrumbs::for('products', function (BreadcrumbTrail $trail, $categoryCode = null) {
    if ($categoryCode) {
        // Fetch the current category and build hierarchy
        $category = Category::where('codice', $categoryCode)->first();

        if ($category) {
            $parents = [];
            $current = $category;

            // Loop to build parent hierarchy (assuming codice follows XXYYZZ format)
            while ($current?->parent_id) {
                $parent = Category::find($current->parent_id);
                if ($parent) {
                    $parents[] = $parent;
                }
                $current = $parent;
            }

            // Reverse to show top to bottom
            foreach (array_reverse($parents) as $parentCategory) {
                $trail->push($parentCategory->nome, route('app.products', ['category' => $parentCategory->codice]));
            }

            $trail->push($category->nome, route('app.products', ['category' => $category->codice]));
        }
    }


    $trail->push('Products', route('app.products'));
});

Breadcrumbs::for('product', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('products');
    $trail->push($product->DESCRIZIONEBREVE, route('app.products.show', $product));
});

Breadcrumbs::for('cart', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Cart', route('app.cart'));
});

Breadcrumbs::for('news', function (BreadcrumbTrail $trail) {
    $trail->push('News', route('app.news'));
});

Breadcrumbs::for('newsDetail', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('news');
    $trail->push($news->title, route('app.news.show', $news));
});


// Breadcrumbs::for('post', function (BreadcrumbTrail $trail, $post) {
//     $trail->parent('home');
//     $trail->push($post->title, route('post', $post));
// });
