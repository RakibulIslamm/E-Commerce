<div class="lg:px-20 sm:px-10 px-5 lg:py-10 py-10">
    @include('app.components.Home.products.Partials.header', ['header' => 'Nuovi Arrivi', 'query'=> 'new'])

    @if (!$newArrivals->isEmpty())
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($newArrivals as $item)
                {{-- @dd($item) --}}
                @include('app.components.Home.products.Partials.product-item', [
                    'product' => $item,
                ])
            @endforeach
        </div>
        @else
            <h2 class="text-gray-300 font-bold text-2xl mt-10">Nessun prodotto trovato.</h2>
        @endif
</div>
