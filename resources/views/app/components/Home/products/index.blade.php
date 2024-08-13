    <?php
    // $product = [
    //     'title' => 'Sample Product',
    //     'description' => 'This is a sample product description.',
    //     'price' => 19.99,
    //     'category' => 'Demo',
    //     'brand' => 'Sample Brand',
    //     'sku' => '123456789',
    //     'stock' => 100,
    //     'image' => 'sample_product.jpg',
    //     'rating' => 4.5,
    //     'reviews' => 50,
    //     'availability' => true,
    //     'section' => 'Best selling',
    // ];
    ?>
    <div class="lg:px-20 sm:px-10 px-5 lg:py-10 py-10">
        @include('app.components.Home.products.Partials.header', ['header' => 'Best sellers'])

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">


            @if (!$products->isEmpty())
                @foreach ($products as $item)
                    @include('app.components.Home.products.Partials.product-item', ['product' => $item])
                @endforeach
            @else
                <h2 class="text-gray-300 font-bold text-2xl">No product found!</h2>
            @endif
        </div>
    </div>
