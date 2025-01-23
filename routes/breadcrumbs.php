<?php

// routes/breadcrumbs.php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('app.dashboard'));
});

Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
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
