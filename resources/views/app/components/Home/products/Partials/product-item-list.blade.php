<div class="flex items-start gap-5 w-full">

    <div class="relative border w-[300px]">
        <img src="{{ $product->FOTO ? 'data:image/png;base64,' . $product->FOTO : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}"
            alt="" class="w-full h-full object-cover object-center">

        <div class="absolute top-3 left-0">
            @if ($product->PIUVENDUTI and $product->NOVITA)
                <p
                    class="px-4 py-1 rounded-r bg-yellow-700 text-white text-xs group-hover/product:border group-hover/product:border-l-0">
                    Best seller</p>
            @endif

            @if ($product->PIUVENDUTI and !$product->NOVITA)
                <p
                    class="px-4 py-1 rounded-r bg-yellow-700 text-white text-xs group-hover/product:border group-hover/product:border-l-0">
                    Best seller</p>
            @endif

            @if (!$product->PIUVENDUTI and $product->NOVITA)
                <p
                    class="px-4 py-1 rounded-r bg-yellow-700 text-white text-xs group-hover/product:border group-hover/product:border-l-0">
                    New arrieval</p>
            @endif

            @if (isset($section))
            @endif
        </div>
    </div>

    <div class="py-3 w-[calc(100%_-_300px)]">
        <div class="flex items-center gap-10 justify-between w-4/6">
            <a href="{{ route('app.products.show', $product) }}">
                <h3 class="font-semibold text-gray-600 text-2xl group-hover/product:text-white line-clamp-1 flex-1">
                    {{ $product['DESCRIZIONEBREVE'] }}
                </h3>
            </a>
            @if (tenant()->offer_display == 'View cut price')
                <div class="flex items-center gap-4">
                    @if ($product['PREPROMOIMP'])
                        <h3 class="text-lg font-semibold line-through text-rose-700">{{ $product['PRE1IMP'] }}€</h3>
                        <h3 class="text-2xl text-gray-600 font-semibold">{{ $product['PREPROMOIMP'] }}€</h3>
                    @else
                        <h3 class="text-2xl text-gray-600 font-semibold">{{ $product['PRE1IMP'] }}€</h3>
                    @endif
                </div>
                @else
                    <h3 class="text-2xl text-gray-600 font-semibold">{{ $product['PRE1IMP'] }}€</h3>
            @endif
        </div>

        <div class="flex items-center gap-2 mt-1">
            <p class="text-sm">5.0</p>
            <div class="flex items-center gap-1 text-yellow-400">
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
                <x-heroicon-m-star class="w-4 h-4" />
            </div>
            <p class="text-sm">See all 512 reviews</p>
        </div>

        @if (tenant()->product_stock_display == 'Text + Quantity')
            <div class="mt-1">Availability:
                @if ($product->GIACENZA > 0)
                    <span class="font-semibold text-green-500">In Stock</span>
                    <br>
                    <div class="mt-1">
                        <span class="">Quantity:</span>
                        <span class="font-semibold text-green-500">{{$product->GIACENZA}}</span>
                    </div>
                @else
                    <span class="font-semibold text-red-500">Stock Out</span>
                @endif

            </div>
        @elseif (tenant()->product_stock_display == 'Text Only')
            <p>Availability:

                @if ($product->GIACENZA > 0)
                    <span class="font-semibold text-green-500">In Stock</span>
                @else
                    <span class="font-semibold text-red-500">Stock Out</span>
                @endif

            </p>
        @endif

        <div class="flex items-center gap-3 mt-3">
            @if ($product->GIACENZA > 0)
                <button onclick="addToCart({{ $product->id }}, {{ $product }})"
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"><x-lucide-shopping-cart
                        class="w-5 h-5" /> Add</button>
            @else
                <button
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"
                    disabled><x-lucide-shopping-cart class="w-5 h-5" />Stock out</button>
            @endif
            <button
                class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-wishlist-{{ $product->id }}">
                <x-heroicon-o-heart class="w-5 h-5" />
                Wishlist</button>
        </div>

    </div>


</div>
