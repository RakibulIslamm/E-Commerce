@section('title', $product->DESCRIZIONEBREVE)
<x-app-guest-layout>
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'Product details']">
        @section('page_title', 'Product details')



        <div class="flex items-start justify-between gap-5 overflow-hidden">

            <div class="w-4/12 overflow-hidden">
                <div class="swiper-container gallery-slider relative">
                    <div class="swiper-wrapper">
                        @if (isset($product->FOTO))
                            @foreach ($product->FOTO as $img)
                                <div class="swiper-slide">
                                    <img class="w-full border float-right" src="{{ 'data:image/png;base64,' . $img }}"
                                        alt="">
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <img class="w-full border float-right"
                                    src="https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png"
                                    alt="">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="swiper-container gallery-thumbs mt-3">
                    <div class="swiper-wrapper">

                        @if (isset($product->FOTO))
                            @foreach ($product->FOTO as $img)
                                <div class="swiper-slide w-20">
                                    <img class="w-full border" src="{{ 'data:image/png;base64,' . $img }}"
                                        alt="">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="w-8/12 text-gray-800 space-y-3">
                <div>
                    <div class="flex items-center justify-between gap-10 w-10/12 max-w-full">
                        <h1 class="text-2xl font-semibold">{{ $product['DESCRIZIONEBREVE'] }}</h1>
                        <h3 class="text-lg font-semibold">${{ $product['PRE1IMP'] }}</h3>
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
                </div>

                <div class="space-y-1">
                    <p>Code: <span class="font-semibold">290</span></p>
                    <p>Barcode: <span class="font-semibold">8003495106693</span></p>
                    <p>Availability:

                        @if ($product->GIACENZA > 0)
                            <span class="font-semibold text-green-500">In Stock</span>
                        @else
                            <span class="font-semibold text-red-500">Stock Out</span>
                        @endif

                    </p>
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
                <div class="w-full -ml-3">
                    <div id="editor">
                        {!! isset($product['DESCRIZIONEESTESA']) ? $product['DESCRIZIONEESTESA'] : '' !!}
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
                    alert('Product added to cart');
                    window.all_cart = data.cart_items;
                }
                renderSidebarCart();
                renderSidebarSubtotal();
                setCartItemCount();
            });
    }
</script>
