<div class="flex items-center gap-5 w-full border rounded overflow-hidden h-[170px]">

    <div class="relative border aspect-square max-w-[170px] min-w-[170px] min-h-[170px]">
        <img src="{{ $product->FOTO ? tenant_asset($product->FOTO) : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}"
            alt="" class="h-full w-full object-cover object-center">

        <div class="absolute top-3 left-0">
            @if ($product->PIUVENDUTI and !$product->NOVITA)
                <p
                    class="px-4 py-1 rounded-r bg-yellow-700 text-white text-xs group-hover/product:border group-hover/product:border-l-0">
                    Più venduto</p>
            @endif

            @if (!$product->PIUVENDUTI and $product->NOVITA)
                <p
                    class="px-4 py-1 rounded-r bg-yellow-700 text-white text-xs group-hover/product:border group-hover/product:border-l-0">
                    Nuovo arrivo</p>
            @endif

            @if (isset($section))
            @endif
        </div>
    </div>

    <div class="py-3 w-[calc(100%_-_170px)]">
        <div class="flex items-center gap-5 justify-between">
            <a href="{{ route('app.products.show', $product) }}">
                <h3 class="font-semibold text-gray-600 text-2xl group-hover/product:text-white line-clamp-1 flex-1">
                    {{ $product['DESCRIZIONEBREVE'] }}
                </h3>
            </a>
            @php
                $PREPROMOIMP = isset($product['PREPROMOIMP']) && (float)$product['PREPROMOIMP'] > 0 
                ? number_format((float)$product['PREPROMOIMP'], 2) 
                : false;
            @endphp
            @if (tenant()->offer_display === 'View cut price')
                <div class="flex items-center gap-4 pr-5">
                    @if ($PREPROMOIMP)
                        <h3 class="text-lg font-semibold line-through text-rose-700">{{ $product['PRE1IMP'] }}€</h3>
                        <h3 class="text-2xl text-gray-600 font-semibold">{{ $PREPROMOIMP }}€</h3>
                    @else
                        <h3 class="text-2xl text-gray-600 font-semibold">{{ $product['PRE1IMP'] }}€</h3>
                    @endif
                </div>
            @else
                <h3 class="text-2xl text-gray-600 font-semibold">{{ $product['PRE1IMP'] }}€</h3>
            @endif
        </div>

        {{-- <div class="flex items-center gap-2 mt-1">
            <p class="text-sm">5.0</p>
            <div class="flex items-center gap-1 text-yellow-400">
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
            </div>
            <p class="text-sm">See all 512 reviews</p>
        </div> --}}

        @if (tenant()->product_stock_display == 'Text + Quantity')
            <div class="mt-1">Disponibilità:
                @if ($product->GIACENZA > 0)
                    <span class="font-semibold text-green-500">In magazzino</span>
                    <br>
                    <div class="mt-1">
                        <span class="">Quantità:</span>
                        <span class="font-semibold text-green-500">{{$product->GIACENZA}}</span>
                    </div>
                @else
                    <span class="font-semibold text-red-500">Esaurito</span>
                @endif

            </div>
        @elseif (tenant()->product_stock_display == 'Text Only')
            <p>Disponibilità:

                @if ($product->GIACENZA > 0)
                    <span class="font-semibold text-green-500">In magazzino</span>
                @else
                    <span class="font-semibold text-red-500">Esaurito</span>
                @endif

            </p>
        @endif

        <div class="flex items-center gap-3 mt-3">
            @if ($product->GIACENZA > 0)
                <button onclick="addToCart({{ $product->id }}, {{ $product }}, {{$product?->PXC}})"
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"><x-lucide-shopping-cart
                        class="w-5 h-5" /> Aggiungi</button>
            @else
                <button
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"
                    disabled><x-lucide-shopping-cart class="w-5 h-5" />Esaurito</button>
            @endif
            <!-- <button
                class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-wishlist-{{ $product->id }}">
                <x-heroicon-o-heart class="w-5 h-5" />
                Wishlist</button> -->
        </div>

    </div>


</div>
