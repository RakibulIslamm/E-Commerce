<div class="bg-white dark:bg-card rounded-2xl p-3 border transition-all duration-300 transform mx-auto">
    {{-- Product Image --}}
    <div class="rounded-xl mb-6 relative overflow-hidden">
        <img 
            src="{{ $product->FOTO ? tenant_asset($product->FOTO) : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}" 
            alt="{{ $product['DESCRIZIONEBREVE'] }}" 
            class="h-full object-contain relative z-10 drop-shadow-2xl"
        />
    </div>

    {{-- Product Info --}}
    <div class="space-y-3">
        {{-- Title --}}
        <div>
            <a href="{{ route('app.products.show', $product) }}">
                <h3 class="font-semibold text-gray-600 text-2xl group-hover/product:text-white line-clamp-1 flex-1">
                    {{ $product['DESCRIZIONEBREVE'] }}
                </h3>
            </a>
            @if (tenant()->product_stock_display == 'Text + Quantity')
                @if ($product->GIACENZA > 0)
                    <p class=" text-green-500 text-xs">In magazzino</p>
                    <p class=" text-green-500 text-xs m-0 p-0">Quantità: {{$product->GIACENZA}}</p>
                @else
                    <p class=" text-red-500 text-xs">Esaurito</p>
                @endif
            @elseif (tenant()->product_stock_display == 'Text Only')
                <p>Disponibilità:

                    @if ($product->GIACENZA > 0)
                        <p class=" text-green-500 text-xs">In magazzino</p>
                    @else
                        <p class=" text-red-500 text-xs">Esaurito</p>
                    @endif

                </p>
            @endif
        </div>

        {{-- New product or Best seller --}}
        {{-- @if ($product->PIUVENDUTI || $product->NOVITA)
            <p class="text-xs font-medium tracking-wide uppercase text-yellow-600 dark:text-yellow-400">
                {{ $product->PIUVENDUTI ? 'Più venduto' : 'Nuovo arrivo' }}
            </p>
        @endif --}}

        

        {{-- Price --}}
        @php
            $PREPROMOIMP = isset($product['PREPROMOIMP']) && (float)$product['PREPROMOIMP'] > 0 
                ? number_format((float)$product['PREPROMOIMP'], 2) 
                : false;
        @endphp

        <div class="flex items-center justify-between gap-3">
            <p class="text-2xl font-bold text-gray-900 dark:text-foreground">
                @if ($PREPROMOIMP)
                    <span class="text-red-500 line-through text-base mr-2">{{ $product['PRE1IMP'] }}€</span>
                    {{ $PREPROMOIMP }}€
                @else
                    {{ $product['PRE1IMP'] }}€
                @endif
            </p>
            @if ($product->GIACENZA > 0)
                    <button onclick="addToCart({{ $product->id }}, {{ $product }})"
                        class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"><x-lucide-shopping-cart
                            class="w-5 h-5" /> Aggiungi</button>
            @else
                <button
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"
                    disabled><x-lucide-shopping-cart class="w-5 h-5" />Esaurito</button>
            @endif
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
                console.log(data);
                if (data.success) {
                    // alert('Product added to cart');
                    console.log(data);
                    window.all_cart = data.cart_items;
                }
                renderSidebarCart();
                renderSidebarSubtotal();
                setCartItemCount();
            })
            .catch((err)=>{
                console.log(err);
            })
    }
</script>
