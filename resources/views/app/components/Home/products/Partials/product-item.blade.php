<div class="bg-white dark:bg-card rounded-2xl overflow-hidden border transition-all duration-300 transform mx-auto w-full flex flex-col justify-between">
    {{-- Product Image --}}
    <a href="{{ route('app.products.show', $product) }}" class="mb-3 relative aspect-square">
        <img 
            src="{{ $product->FOTO ? tenant_asset($product->FOTO) : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}" 
            alt="{{ $product['DESCRIZIONEBREVE'] }}" 
            class="h-full w-full object-cover object-center relative z-10 drop-shadow-2xl"
        />
    </a>

    {{-- Product Info --}}
    <div class="space-y-3 p-3 h-full flex flex-col justify-between">
        {{-- Title --}}
        <div>
            <a href="{{ route('app.products.show', $product) }}">
                <h3 class="font-semibold text-gray-600 text-xl group-hover/product:text-white line-clamp-2 flex-1">
                    {{ $product['DESCRIZIONEBREVE'] }}
                </h3>
            </a>
            @if (tenant()->product_stock_display == 'Text + Quantity' && !$hide_catalogo_mandatory_con_conferma)
                @if ($product->GIACENZA > 0)
                    <p class=" text-green-500 text-xs">In magazzino</p>
                    <p class=" text-green-500 text-xs m-0 p-0">Quantità: {{$product->GIACENZA}}</p>
                @else
                    <p class=" text-red-500 text-xs">Esaurito</p>
                @endif
            @elseif (tenant()->product_stock_display == 'Text Only' && !$hide_catalogo_mandatory_con_conferma)
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
            $price = match (true) {
                $user && $user->price_list == 3 => $product['PRE3IMP'],
                $user && $user->price_list == 2 => $product['PRE2IMP'],
                $user && $user->price_list == 1 => $product['PRE1IMP'],
                default => $product['PRE1IMP'],
            };

            $price_with_vat = match (true) {
                $user && $user->price_list == 3 => $product['PRE3IVA'],
                $user && $user->price_list == 2 => $product['PRE2IVA'],
                $user && $user->price_list == 1 => $product['PRE1IVA'],
                default => $product['PRE1IVA'],
            };
        @endphp

        
        <div class="flex items-start flex-col justify-end gap-3">
            @if (!$hide_catalogo_mandatory_con_conferma)
                @if (tenant()?->price_with_vat)
                    <div class="flex items-center">
                        <h3 class="text-xl font-semibold">{{ $price_with_vat }}€</h3>
                        <sup class="ml-2 font-bold text-green-900">IVATO</sup>
                    </div>
                @else
                    <div class="flex items-center">
                        <h3 class="text-xl font-semibold">{{ $price }}€</h3>
                        <sup class="ml-1 font-bold text-red-900">SENZA IVA</sup>
                    </div>
                @endif
            @endif
            @if (!$hide_catalogo_mandatory && !$hide_catalogo_mandatory_con_conferma)
                @if ($product->GIACENZA > 0)
                    <div class="w-full flex items-start justify-between gap-2">
                        
                        
                        <button onclick="addToCart({{ $product->id }}, {{ $product }}, {{$product?->PXC}})"
                        class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"><x-lucide-shopping-cart
                            class="w-5 h-5" /> Aggiungi</button>
                        

                        <div id="plus-minus-btn-{{ $product->id }}" class="hidden">
                            <div class="flex items-center gap-2 flex-wrap">
                                {{-- Plus/Minus --}}
                                <div class="flex items-center border rounded overflow-hidden">
                                    <button onclick="cartDecreaseInView({{ $product->id }}, {{ $product?->PXC }})"
                                        class="flex items-center justify-center bg-gray-100 w-7 h-7 text-sm hover:bg-blue-500 hover:text-white transition">
                                        -
                                    </button>
                                    <input 
                                    class="h-7 max-w-14 text-center text-sm border-l border-r border-gray-300"
                                    id="cart-in-view-quantity-input-{{ $product->id }}" type="text" 
                                    value="1"
                                    onblur="onBlurCartIncreaseDecreaseInView({{ $product->id }}, this.value)"
                                    onkeydown="if(event.key === 'Enter'){ onBlurCartIncreaseDecreaseInView({{ $product->id }}, this.value); this.blur(); }"
                                    />
                                    <button onclick="cartIncreaseInView({{ $product->id }}, {{ $product?->PXC }})"
                                        class="flex items-center justify-center bg-gray-100 w-7 h-7 text-sm hover:bg-blue-500 hover:text-white transition">
                                        +
                                    </button>
                                </div>
                                @if ($product?->PXC > 1)
                                    <p class="mt-1 text-xs text-gray-500" id="n-colli-{{ $product->id }}">(N. colli: 1)</p>
                                @endif
                                {{-- Spinner --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="w-5 h-5 animate-spin invisible update-quantity-spin-{{ $product->id }}"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                    <path fill-rule="evenodd"
                                        d="M8 3a5 5 0 0 0-3.857 1.818.5.5 0 1 1-.771-.636A6 6 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3zM3.1 9a5 5 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6 6 0 0 1 2.083 9H3.1z" />
                                </svg>
                            </div>
                        </div>     
                    </div>
                @else
                    <button
                        class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"
                        disabled><x-lucide-shopping-cart class="w-5 h-5" />Esaurito</button>
                @endif
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
                if (data.success) {
                    window.all_cart = data.cart_items;
                    renderSidebarCart();
                    renderSidebarSubtotal();
                    setCartItemCount();
                }
                else{
                    alert(data.message);
                }
            })
            .catch((err)=>{
                console.log(err);
            })
    }
</script>
