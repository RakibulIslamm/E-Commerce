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
        <a href="{{ route('app.products.show', $product) }}">
            <h3 class="font-semibold text-gray-600 text-2xl group-hover/product:text-white line-clamp-1 flex-1">
                {{ $product['DESCRIZIONEBREVE'] }}
            </h3>
        </a>

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

        <div class="w-8/12 mt-4">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, quia. Dicta, laudantium facere
                reprehenderit architecto pariatur aperiam dolore aspernatur molestias.</p>
        </div>

        <div class="my-3 flex items-center gap-2">
            <p>Availability:</p>
            @if ($product->GIACENZA > 0)
                <p class=" text-green-500">In stock</p>
            @else
                <p class=" text-red-500">Stock out</p>
            @endif
        </div>

        <div class="flex items-center gap-3">
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
