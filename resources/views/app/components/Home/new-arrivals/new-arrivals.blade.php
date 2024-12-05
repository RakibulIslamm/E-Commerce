<div class="lg:px-20 sm:px-10 px-5 lg:py-10 py-10">
    @include('app.components.Home.products.Partials.header', ['header' => 'New Arrivals', 'query'=> 'new'])

    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        @if (!$newArrivals->isEmpty())
            @foreach ($newArrivals as $item)
                {{-- @dd($item) --}}
                @include('app.components.Home.products.Partials.product-item', [
                    'product' => $item,
                ])
            @endforeach
        @else
            <h2 class="text-gray-300 font-bold text-2xl">Nessun prodotto trovato.</h2>
        @endif
    </div>
</div>
