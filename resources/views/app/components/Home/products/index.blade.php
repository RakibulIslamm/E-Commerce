    <?php
    $product = [
        'title' => 'Sample Product',
        'description' => 'This is a sample product description.',
        'price' => 19.99,
        'category' => 'Demo',
        'brand' => 'Sample Brand',
        'sku' => '123456789',
        'stock' => 100,
        'image' => 'sample_product.jpg',
        'rating' => 4.5,
        'reviews' => 50,
        'availability' => true,
        'section' => 'Best selling',
    ];
    ?>
    <div class="px-20 py-10">
        @include('app.components.Home.products.Partials.header', ['header' => 'Best sellers'])

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @include('app.components.Home.products.Partials.product-item', ['product' => $product])
            @include('app.components.Home.products.Partials.product-item', ['product' => $product])
            @include('app.components.Home.products.Partials.product-item', ['product' => $product])
            @include('app.components.Home.products.Partials.product-item', ['product' => $product])
        </div>
    </div>
