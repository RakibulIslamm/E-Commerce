<div class="group/product relative">
    <div
        class="aspect-h-1 aspect-w-1 w-full min-h-[300px] max-h-[350px] overflow-hidden bg-gray-200 relative rounded-md border">
        <div
            class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent to-70% opacity-60 group-hover/product:opacity-100 group-hover/product:to-[#00000049] transition-opacity ease-in-out duration-300">
        </div>
        <img src="{{ $product->FOTO ? 'data:image/png;base64,' . $product->FOTO : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}"
            alt="" class="min-h-[300px] max-h-[350px] w-full object-cover object-center">
        <div class=" absolute top-0 left-0 w-full h-full flex flex-col justify-between items-center">
            <div class="w-full flex items-center justify-between mt-3">
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
                        Nuovo arrivo</p>
                @endif

                @if (isset($section))
                @endif
                <button class="px-4 py-1 group/wish-list text-red-500 cursor-pointer ml-auto" title="Add to wishlist">
                    <x-heroicon-o-heart class="w-6 h-6 group-hover/wish-list:hidden group-hover/product:text-white" />
                    <x-heroicon-s-heart class="w-6 h-6 hidden group-hover/wish-list:block " />
                </button>
            </div>
            <div
                class="flex flex-col items-center gap-2 invisible opacity-0 group-hover/product:opacity-100 group-hover/product:visible transition-all ease-in-out">
                @if ($product->GIACENZA > 0)
                    <button onclick="addToCart({{ $product->id }}, {{ $product }})"
                        class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"><x-lucide-shopping-cart
                            class="w-5 h-5" /> Add</button>
                @else
                    <button
                        class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"
                        disabled><x-lucide-shopping-cart class="w-5 h-5" />Stock out</button>
                @endif
                {{-- <button class="px-5 py-1 text-sm bg-blue-700 active:bg-blue-500 text-white rounded">Buy Now</button> --}}
            </div>
            <div class="w-full flex items-center justify-between">
                <div class="px-4 mb-3">
                    {{-- @dd($product['DESCRIZIONEBREVE']) --}}
                    <a href="{{ route('app.products.show', $product) }}">
                        <h3
                            class="font-semibold text-slate-100 group-hover/product:text-white drop-shadow-xl line-clamp-1 flex-1">
                            {{ $product['DESCRIZIONEBREVE'] }}
                        </h3>
                    </a>
                    @if ($product->GIACENZA > 0)
                        <p class="text-xs text-yellow-400">In magazzino</p>
                    @else
                        <p class="text-xs text-red-300">Esaurito</p>
                    @endif
                </div>
                <div class="px-4 text-right">
                    <h3 class="font-semibold text-red-500 group-hover/product:text-red-500 drop-shadow-xl text-sm line-through">
                        {{ $product['PRE1IMP'] }}€</h3>
                    <h3 class="font-semibold text-slate-100 group-hover/product:text-white drop-shadow-xl">
                            {{ $product['PRE1IMP'] }}€</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(productId, product, quantity = 1) {
        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // alert('Product added to cart');
                    console.log(data);
                    window.all_cart = data.cart_items;
                }
                renderSidebarCart();
                renderSidebarSubtotal();
                setCartItemCount();
            });
    }
</script>
