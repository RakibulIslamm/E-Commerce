    
    <div class="lg:px-20 sm:px-10 px-5 lg:py-10 py-10">
        @include('app.components.Home.products.Partials.header', ['header' => 'Best sellers', 'query'=>'best_seller'])

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @if (!$bestSellers->isEmpty())
                @foreach ($bestSellers as $item)
                    @include('app.components.Home.products.Partials.product-item', ['product' => $item])
                @endforeach
            @endif
        </div>
        @if ($bestSellers->isEmpty())
            <h2 class="text-gray-300 font-semibold text-2xl w-full">Nessun prodotto trovato.</h2>
        @endif
    </div>
