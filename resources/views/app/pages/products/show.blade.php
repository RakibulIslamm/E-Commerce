@section('title', $product->DESCRIZIONEBREVE)
@section('title', $product->DESCRIZIONEBREVE)
<x-app-guest-layout>
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'Dettaglio prodotto']">
        @section('page_title', 'Dettaglio prodotto')

        <div class="flex flex-col lg:flex-row items-start justify-between gap-5 overflow-hidden">
            <!-- Product Images -->
            {{-- tenancy/assets/tenant2c1ec478-e1b2-440f-b522-aa3c022e6da4/app/public/ --}}
            <div class="w-full lg:w-4/12 overflow-hidden">
                <div class="swiper-container gallery-slider relative">
                    <div class="swiper-wrapper">
                        @if (isset($product->FOTO) && count($product->FOTO))
                            @foreach ($product->FOTO as $img)
                                <div class="swiper-slide aspect-square">
                                    <a data-fancybox="gallery" href="{{tenant_asset($img)}}">
                                        <img class="w-full h-full aspect-square border rounded-md" src="{{tenant_asset($img)}}" alt="">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <a data-fancybox="gallery" href="https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png" class="aspect-square">
                                    <img class="w-full h-full aspect-square border rounded-md"
                                        src="https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png"
                                        alt="">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="swiper-container gallery-thumbs mt-3">
                    <div class="swiper-wrapper">
                        @if (isset($product->FOTO) && (count($product->FOTO) > 1))
                            @foreach ($product->FOTO as $img)
                                <div class="swiper-slide w-12 md:w-16 aspect-square">
                                    <img class="w-full h-full aspect-square border rounded-md object-cover object-center" src="{{tenant_asset($img)}}" alt="">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="w-full lg:w-8/12 text-gray-800 space-y-5">
                <div>
                    <!-- Category -->
                    @if ($product['category'] instanceof \Illuminate\Support\Collection)
                        @foreach ($product['category'] as $child)
                            <p class="px-3 py-1 rounded bg-yellow-100 border border-gray-200 inline-block text-xs mb-2">
                                {{ $child->nome }}
                            </p>
                        @endforeach
                    @elseif ($product['category'])
                        <p class="px-3 py-1 rounded bg-yellow-100 border border-gray-200 inline-block text-xs mb-2">
                            {{ $product['category']->nome }}
                        </p>
                    @endif

                    

                    <!-- Title and Price -->
                    <div class="">
                        <h1 class="text-2xl font-semibold">{{ $product['DESCRIZIONEBREVE'] }}</h1>
                       @if (!empty($product?->PXC) && $product->PXC >= 1)
                           <span class="text-xs">PZ {{ $product->PXC }} per collo</span>
                       @endif
                    </div>

                    <!-- Rating -->
                    {{-- <div class="flex items-center gap-2 mt-2">
                        <p class="text-sm">5.0</p>
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for ($i = 0; $i < 5; $i++)
                                <x-heroicon-m-star class="w-4 h-4" />
                            @endfor
                        </div>
                        <p class="text-sm">See all 512 reviews</p>
                    </div> --}}
                </div>

                <!-- Product Info -->
                <div class="space-y-1">
                    {{-- <p>Code: <span class="font-semibold">290</span></p> --}}
                    <p>
                        Barcode: 
                        <span class="font-semibold">
                            {{ explode('|', $product->BARCODE ?? 'N/A')[0] }}
                        </span>
                    </p>
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
                </div>

                <!-- Size and Color -->
                @if (tenant()->size_color_options)
                    <div class="flex flex-wrap items-center gap-5">
                        <p>Size:
                            <span class="font-semibold text-gray-500">{{ $product->TAGLIA ?? 'N/A' }}</span>
                        </p>
                        <p>Color:
                            <span style="color: {{ $product->COLORE }}" class="font-semibold text-gray-500">{{ $product->COLORE ?? 'N/A' }}</span>
                        </p>
                    </div>
                @endif

                <!-- Add to Cart Button -->
                <div class="flex items-center gap-5">
                    @if (!$hide_catalogo_mandatory_con_conferma && !$hide_catalogo_mandatory)
                        <button 
                            onclick="addToCart({{ $product->id }}, {{ $product }}, {{$product?->PXC}})" 
                            class="px-5 py-2 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}" 
                            @if ($product->GIACENZA <= 0) disabled @endif>
                            <x-lucide-shopping-cart class="w-5 h-5" />
                            {{ $product->GIACENZA > 0 ? 'Aggiungi' : 'Esaurito' }}
                        </button>
                        @php
                            $PREPROMOIMP = isset($product['PREPROMOIMP']) && (float)$product['PREPROMOIMP'] > 0 
                            ? number_format((float)$product['PREPROMOIMP'], 2) 
                            : false;
                        @endphp
                    @endif
                    @if (!$hide_catalogo_mandatory_con_conferma)
                        @if (tenant()?->price_with_vat)
                            <div class="flex items-center">
                                <h3 class="text-3xl font-semibold">{{ $product['PRE1IVA'] }}€</h3>
                                <sup class="ml-3 font-bold text-green-900">IVATO</sup>
                            </div>
                        @else
                            <div class="flex items-center">
                                <h3 class="text-3xl font-semibold">{{ $product['PRE1IMP'] }}€</h3>
                                <sup class="ml-3 font-bold text-red-900">SENZA IVA</sup>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="hidden" id="plus-minus-btn-{{ $product->id }}">
                    <hr class="pb-3">
                    <div class="flex items-center gap-1">
                        <button onclick="cartDecreaseInView({{ $product->id }}, {{$product?->PXC}})"
                        class="flex items-center justify-center cursor-pointer rounded-l bg-gray-100 sm:h-8 sm:w-10 w-5 h-5 duration-100 hover:bg-blue-500 hover:text-blue-50">
                        - </button>
                        <input
                        class="sm:h-8 sm:w-14 h-5 w-8 text-center sm:text-base text-xs" id="cart-in-view-quantity-input-{{ $product->id }}"
                        type="text" 
                        value=""
                        onkeydown="if(event.key === 'Enter'){ onBlurCartIncreaseDecreaseInView({{ $product->id }}, this.value); this.blur(); }"
                        onblur="onBlurCartIncreaseDecreaseInView({{ $product->id }}, this.value); this.blur()"
                        />
                        <button onclick="cartIncreaseInView({{ $product->id }}, {{$product?->PXC}})"
                            class="flex items-center justify-center cursor-pointer rounded-r bg-gray-100 sm:h-8 sm:w-10 w-5 h-5 duration-100 hover:bg-blue-500 hover:text-blue-50">
                            + </button>  
                            
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 animate-spin mr-3 invisible update-quantity-spin-{{$product->id}}"
                        viewBox="0 0 16 16">
                            <path
                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                            <path fill-rule="evenodd"
                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                        </svg>
                    </div>
                    @if ($product?->PXC > 1)
                        <p class="p-2 text-sm" id="n-colli-{{$product->id}}">(N. colli: 1)</p>
                    @endif
                </div>
                
                @if (!$user && tenant()?->registration_process != 'Optional')
                    <div>
                        <h3 class="text-xl font-bold">Attenzione, per effettuare l'acquisto devi essere un utente registrato</h3>
                        <span class="">
                            Entra con le tue credenziali oppure registrati cliccando <a class="font-bold underline" href="/register">qui</a>
                        </span>
                    </div>
                @endif

                <!-- Description -->
                <div class="w-full">
                    <div id="editor">
                        {!! $product['DESCRIZIONEESTESA'] ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </x-page-layout>
</x-app-guest-layout>



<script>
    const product = @json($product);

    const quill = new Quill('#editor', {
        placeholder: '',
        theme: 'bubble',
    });
    quill.enable(false);

    var thumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: "auto",
        freeMode: true,
        watchSlidesProgress: true,
    });

    const swiper = new Swiper('.gallery-slider', {
        spaceBetween: 10,
        slidesPerView: 1,
        loopedSlides: 6,
        thumbs: {
            swiper: thumbs,
        },
    });

    Fancybox.bind('[data-fancybox="gallery"]', {
        Toolbar: {
        display: [
            { id: "zoom", position: "center" },
            "close",
        ],
        },
        Thumbs: false,
        animated: true,
    });

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
                console.log(data)
                if (data.success) {
                    window.all_cart = data.cart_items;
                    renderSidebarCart();
                    renderSidebarSubtotal();
                    setCartItemCount();
                } else{
                    alert("Qualcosa è andato storto, riprova più tardi.");
                }
            });
    }

</script>
