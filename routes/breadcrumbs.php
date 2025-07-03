<?php

// routes/breadcrumbs.php

use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Arr;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('app.dashboard')); // You can keep 'Dashboard' if it's used as-is in the UI
});

Breadcrumbs::for('products', function (BreadcrumbTrail $trail, $categoryCode = null) {
    $trail->push('Prodotti', route('app.products'));
    if ($categoryCode) {
        // Ottieni la categoria corrente e costruisci la gerarchia
        $category = Category::where('codice', $categoryCode)->first();

        if ($category) {
            $parents = [];
            $current = $category;

            // Ciclo per costruire la gerarchia dei genitori (supponendo codice nel formato XXYYZZ)
            while ($current?->parent_id) {
                $parent = Category::find($current->parent_id);
                if ($parent) {
                    $parents[] = $parent;
                }
                $current = $parent;
            }

            // Inverti per mostrare dall'alto verso il basso
            foreach (array_reverse($parents) as $parentCategory) {
                $trail->push($parentCategory->nome, route('app.products', ['category' => $parentCategory->codice]));
            }

            $trail->push($category->nome, route('app.products', ['category' => $category->codice]));
        }
    }
});

Breadcrumbs::for('product', function (BreadcrumbTrail $trail, $product) {
    // Start with "Prodotti" base link
    $trail->push('Prodotti', route('app.products'));
    
    $categoryCodes = $product->CATEGORIEESOTTOCATEGORIE;

    // Get the deepest category (last one)
    $categoryCode = is_array($categoryCodes) ? Arr::last($categoryCodes) : null;

    if ($categoryCode) {
        $category = Category::where('codice', $categoryCode)->first();

        if ($category) {
            $parents = [];
            $current = $category;

            // Traverse parent hierarchy
            while ($current?->parent_id) {
                $parent = Category::find($current->parent_id);
                if ($parent) {
                    $parents[] = $parent;
                }
                $current = $parent;
            }

            // Push parent categories (top-down)
            foreach (array_reverse($parents) as $parentCategory) {
                $trail->push($parentCategory->nome, route('app.products', ['category' => $parentCategory->codice]));
            }

            // Push current category
            $trail->push($category->nome, route('app.products', ['category' => $category->codice]));
        }
    }

    // Finally, push the product name
    $trail->push($product->DESCRIZIONEBREVE, route('app.products.show', $product));
});

Breadcrumbs::for('cart', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Carrello', route('app.cart'));
});

Breadcrumbs::for('news', function (BreadcrumbTrail $trail) {
    $trail->push('Notizie', route('app.news'));
});

Breadcrumbs::for('newsDetail', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('news');
    $trail->push($news->title, route('app.news.show', $news));
});

// Esempio commentato - se usato, tradurre anche qui
// Breadcrumbs::for('post', function (BreadcrumbTrail $trail, $post) {
//     $trail->parent('home');
//     $trail->push($post->title, route('post', $post));
// });
