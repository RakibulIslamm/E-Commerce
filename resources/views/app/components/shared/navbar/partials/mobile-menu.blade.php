<?php

$logo = null;

// dd($site_settings);

if (isset($site_settings->brand_info)) {
    $brand_info = $site_settings->brand_info;
    $logo = isset($brand_info['logo']) ? $brand_info['logo'] : null;
}

?>


<div
    class="bg-white h-[60px] w-full flex items-center justify-between px-5 sm:px-10 lg:hidden sticky top-0 right-0 z-40 border-b">

    <button onclick="openMobileMenu()">Menu</button>

    <a href="/" class="flex items-center gap-2">
        <img class="h-10 w-auto object-cover" src="{{ $logo ?? '/images/logo.png' }}" alt="">
    </a>

    <div class="flex items-center gap-8">
        <button class="group -m-2 flex items-center p-2 relative text-gray-500" onclick="openCart()">
            <x-lucide-shopping-cart class="w-7 h-7" />
            <span
                class=" absolute top-0 right-0 text-xs group-hover:text-gray-800 bg-yellow-500 text-white rounded-full w-5 h-5 flex items-center justify-center cart-count">0</span>
            <span class="sr-only">items in cart, view bag</span>
        </button>
    </div>

</div>

<div id="mobile-menu"
    class="h-screen fixed top-0 left-0 z-50 bg-white w-full sm:px-10 flex justify-start flex-col -translate-x-full transition-all ease-in-out lg:hidden">
    <div class="z-50 bg-white p-3 ml-auto">
        <button onclick="closeMobileMenu()" type="button" class="">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="w-full h-full space-y-8 overflow-y-auto py-6 px-5">
        <div class="relative w-full space-y-1">
            <label for="search-categories-mobile" class="sr-only">Categories</label>
            <select id="search-categories-mobile" name="search-categories"
                class="w-full rounded-md py-2 pl-2 pr-7 text-gray-900 border border-gray-200 outline-none
            focus:outline-blue-300 focus:outline-2 focus:-outline-offset-2 focus:z-10 appearance-none">
                <option value="" class="px-2 py-1">Tutti</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->codice }}" class="px-2 py-1">{{ $item->nome }}
                    </option>
                @endforeach
            </select>
            <div class="relative">
                <input type="text" name="search" id="search-text-mobile"
                    class="w-full relative rounded py-2 pl-3 pr-8 text-gray-900 border border-gray-200 outline-none
                  focus:outline-blue-300 focus:outline-2 focus:-outline-offset-2 focus:z-10"
                    placeholder="Ricerca prodotto...">

                <button
                    class="w-7 h-7 absolute right-2 top-1/2 -translate-y-1/2 z-50 text-gray-500 cursor-pointer transition-all ease-in-out duration-100"
                    onclick="handleSearchMobile()">
                    <x-lucide-search id="search-icon-show" />
                </button>
            </div>
        </div>
        <div class="flex items-center justify-center flex-col gap-6">
            <a href="/" class="flex items-center text-xl uppercase font-medium">Home</a>
            <a href="{{ route('app.products') }}" class="flex items-center text-xl uppercase font-medium">Prodotti</a>
            <a href="/agency" class="flex items-center text-xl uppercase font-medium">Chi siamo</a>
            <a href="/news" class="flex items-center text-xl uppercase font-medium">Notizie</a>
            <a href="{{ route('app.contact') }}" class="flex items-center text-xl uppercase font-medium">Contatti</a>
        </div>
    </div>
</div>

<script>
    const mobileMenu = document.getElementById('mobile-menu');
    const categoryElementMobie = document.getElementById('search-categories-mobile');
    const searchTextElementMobie = document.getElementById('search-text-mobile');

    function openMobileMenu() {
        mobileMenu.classList.remove('-translate-x-full')
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileMenu() {
        mobileMenu.classList.add('-translate-x-full')
        document.body.classList.remove('overflow-hidden');
    }

    // Mobile search
    const urlMobie = new URL(window.location.href);
    const paramsMobie = new URLSearchParams(urlMobie.search);
    const categoryMobie = params.get('category');
    const searchMobie = params.get('search');
    const order_byMobie = params.get('order_by');
    const limitMobie = params.get('limit');
    let urlHrefMobie = '/products?';

    function handleSearchMobile() {
        const category = categoryElementMobie?.value;
        const searchText = searchTextElementMobie?.value;


        urlHrefMobie += category ? "category=" + category + '&' : "";
        urlHrefMobie += searchText ? "search=" + searchText + '&' : "";
        urlHrefMobie += order_byMobie ? "order_by=" + order_byMobie + '&' : "";
        urlHrefMobie += limitMobie ? "limit=" + limitMobie + '&' : "";

        window.location.href = urlHrefMobie.slice(0, -1);
        console.log(urlHrefMobie.slice(0, -1));
    }

    if (categoryMobie) categoryElementMobie.value = categoryMobie;
    if (searchMobie) searchTextElementMobie.value = searchMobie;
</script>
