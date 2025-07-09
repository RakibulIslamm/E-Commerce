<div class="flex items-center gap-5 w-full border rounded overflow-hidden h-[170px]">

    <a href="{{ route('app.products.show', $product) }}" class="relative border aspect-square max-w-[170px] min-w-[170px] min-h-[170px]">
        <img 
            src="{{ $product->FOTO ? tenant_asset($product->FOTO) : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}"
            alt="" class="h-full w-full aspect-square object-cover object-center">

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
    </a>

    <div class="py-3 w-[calc(100%_-_170px)]">
        <div class="flex items-center gap-5 justify-between">
            <a href="{{ route('app.products.show', $product) }}">
                <h3 class="font-semibold text-gray-600 text-2xl group-hover/product:text-white line-clamp-1 flex-1">
                    {{ $product['DESCRIZIONEBREVE'] }}
                </h3>
            </a>

            @php
                $price = match (true) {
                    auth()?->user() && auth()?->user()?->price_list == 3 => $product['PRE3IMP'],
                    auth()?->user() && auth()?->user()?->price_list == 2 => $product['PRE2IMP'],
                    auth()?->user() && auth()?->user()?->price_list == 1 => $product['PRE1IMP'],
                    default => $product['PRE1IMP'],
                };

                $price_with_vat = match (true) {
                    auth()?->user() && auth()?->user()?->price_list == 3 => $product['PRE3IVA'],
                    auth()?->user() && auth()?->user()?->price_list == 2 => $product['PRE2IVA'],
                    auth()?->user() && auth()?->user()?->price_list == 1 => $product['PRE1IVA'],
                    default => $product['PRE1IVA'],
                };
            @endphp
           
            @if (!$hide_catalogo_mandatory_con_conferma)
                <div class="flex items-center gap-4 pr-5">
                    @if (tenant()?->price_with_vat)
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold">{{ $price_with_vat }}€</h3>
                            <sup class="ml-2 text-xs font-bold text-green-900">IVATO</sup>
                        </div>
                    @else
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold">{{ $price }}€</h3>
                            <sup class="ml-1 font-bold text-xs text-red-900">SENZA IVA</sup>
                        </div>
                    @endif
                        </div>
            @endif
        </div>

        @if (tenant()->product_stock_display == 'Text + Quantity' && !$hide_catalogo_mandatory_con_conferma)
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
        @elseif (tenant()->product_stock_display == 'Text Only' && !$hide_catalogo_mandatory_con_conferma)
            <p>Disponibilità:

                @if ($product->GIACENZA > 0)
                    <span class="font-semibold text-green-500">In magazzino</span>
                @else
                    <span class="font-semibold text-red-500">Esaurito</span>
                @endif

            </p>
        @endif

        @if (!$hide_catalogo_mandatory_con_conferma && !$hide_catalogo_mandatory)
            <div class="flex items-center gap-3 mt-3">
                @if ($product->GIACENZA > 0)
                    <div class="w-full flex items-start gap-2">
                        <button onclick="addToCart({{ $product->id }}, {{ $product }}, {{$product?->PXC}})"
                            class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}"><x-lucide-shopping-cart
                                class="w-5 h-5" /> Aggiungi</button>
                            <div id="list-plus-minus-btn-{{ $product->id }}" class="hidden">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        {{-- Plus/Minus --}}
                                        <div class="flex items-center border rounded overflow-hidden">
                                            <button onclick="cartDecreaseInView({{ $product->id }}, {{ $product?->PXC }})"
                                                class="flex items-center justify-center bg-gray-100 w-7 h-7 text-sm hover:bg-blue-500 hover:text-white transition">
                                                -
                                            </button>
                                            <input 
                                                class="h-7 max-w-14 text-center text-sm border-l border-r border-gray-300"
                                                id="list-cart-in-view-quantity-input-{{ $product->id }}" 
                                                type="text" 
                                                value="1"
                                                onblur="onBlurCartIncreaseDecreaseInView({{ $product->id }}, this.value)"
                                                onkeydown="if(event.key === 'Enter'){ onBlurCartIncreaseDecreaseInView({{ $product->id }}, this.value); this.blur(); }"
                                            />

                                            <button onclick="cartIncreaseInView({{ $product->id }}, {{ $product?->PXC }})"
                                                class="flex items-center justify-center bg-gray-100 w-7 h-7 text-sm hover:bg-blue-500 hover:text-white transition">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    @if ($product?->PXC > 1)
                                        <p class="mt-1 text-xs text-right text-gray-500" id="n-colli-{{ $product->id }}">(N. colli: 1)</p>
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
                <!-- <button
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-wishlist-{{ $product->id }}">
                    <x-heroicon-o-heart class="w-5 h-5" />
                    Wishlist</button> -->
            </div>
        @endif

    </div>


</div>
