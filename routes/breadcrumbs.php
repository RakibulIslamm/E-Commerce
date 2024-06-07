<?php

// routes/breadcrumbs.php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('app.dashboard'));
});

Breadcrumbs::for('post', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('home');
    $trail->push($post->title, route('post', $post));
});
