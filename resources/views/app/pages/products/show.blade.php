@section('title', $product->DESCRIZIONEBREVE)
@section('title', $product->DESCRIZIONEBREVE)
<x-app-guest-layout>
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'Dettaglio prodotto']">
        @section('page_title', 'Dettaglio prodotto')

        <div class="flex flex-col lg:flex-row items-start justify-between gap-5 overflow-hidden">
            <!-- Product Images -->
            <div class="w-full lg:w-4/12 overflow-hidden">
                <div class="swiper-container gallery-slider relative">
                    <div class="swiper-wrapper">
                        @if (isset($product->FOTO) && count($product->FOTO))
                            @foreach ($product->FOTO as $img)
                                <div class="swiper-slide">
                                    <img class="w-full border rounded-md" src="{{ tenant_asset($img) }}" alt="">
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <img class="w-full border rounded-md"
                                     src="https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png"
                                     alt="">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="swiper-container gallery-thumbs mt-3">
                    <div class="swiper-wrapper">
                        @if (isset($product->FOTO) && (count($product->FOTO) > 1))
                            @foreach ($product->FOTO as $img)
                                <div class="swiper-slide w-16 md:w-20">
                                    <img class="w-full border rounded-md" src="{{ tenant_asset($img) }}" alt="">
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
                    <p class="px-3 py-1 rounded bg-yellow-100 border border-gray-200 inline-block text-xs mb-2">
                        @if ($product['category'] instanceof \Illuminate\Support\Collection)
                            @foreach ($product['category'] as $child)
                                {{ $child->nome }}
                            @endforeach
                        @elseif ($product['category'])
                            {{ $product['category']->nome }}
                        @else
                            No Category
                        @endif
                    </p>

                    <!-- Title and Price -->
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <h1 class="text-2xl font-semibold">{{ $product['DESCRIZIONEBREVE'] }}</h1>
                        @php
                            $PREPROMOIMP = isset($product['PREPROMOIMP']) && (float)$product['PREPROMOIMP'] > 0 
                            ? number_format((float)$product['PREPROMOIMP'], 2) 
                            : false;
                        @endphp
                        <div class="flex items-center gap-2">
                            @if ($PREPROMOIMP)
                                <h3 class="text-lg font-semibold line-through text-rose-700">{{ $product['PRE1IMP'] }}€</h3>
                                <h3 class="text-lg font-semibold">{{ $PREPROMOIMP }}€</h3>
                            @else
                                <h3 class="text-lg font-semibold">{{ $product['PRE1IMP'] }}€</h3>
                            @endif
                        </div>
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
                    <p>Barcode: <span class="font-semibold">{{$product->BARCODE ?? "N/A"}}</span></p>
                    <div>
                        Availability:
                        @if ($product->GIACENZA > 0)
                            <span class="font-semibold text-green-500">In Stock</span>
                            <br>
                            <span class="mt-1 block">
                                Quantity: <span class="font-semibold text-green-500">{{$product->GIACENZA}}</span>
                            </span>
                        @else
                            <span class="font-semibold text-red-500">Stock Out</span>
                        @endif
                    </div>
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
                <div class="flex items-center gap-3">
                    <button 
                        onclick="addToCart({{ $product->id }}, {{ $product }})" 
                        class="px-5 py-2 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2 disabled:bg-gray-300 add-to-cart-{{ $product->id }}" 
                        @if ($product->GIACENZA <= 0) disabled @endif>
                        <x-lucide-shopping-cart class="w-5 h-5" />
                        {{ $product->GIACENZA > 0 ? 'Aggiungi' : 'Esaurito' }}
                    </button>
                </div>

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
    const quill = new Quill('#editor', {
        placeholder: 'Compose an epic...',
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
                    window.all_cart = data.cart_items;
                }
                renderSidebarCart();
                renderSidebarSubtotal();
                setCartItemCount();
            });
    }
</script>
