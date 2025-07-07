<?php

$logo = null;

// dd($site_settings);

if (isset($site_settings->brand_info)) {
    $brand_info = $site_settings->brand_info;
    $logo = isset($brand_info['logo']) ? $brand_info['logo'] : null;
}

?>


<div
    class="bg-white h-[60px] w-full flex items-center justify-between px-5 sm:px-10 lg:hidden sticky top-0 right-0 z-40 border-b shadow-sm">

    <button onclick="openMobileMenu()" class="text-gray-700 font-semibold text-sm tracking-wide">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <a href="/" class="flex items-center gap-2">
        <img class="h-10 w-auto object-contain" src="{{ $logo ?? '/images/logo.png' }}" alt="Logo">
    </a>

    <div class="flex items-center gap-4">
        <button class="group relative p-2 text-gray-500 hover:text-gray-800 transition-colors" onclick="openCart()">
            <x-lucide-shopping-cart class="w-7 h-7" />
            <span
                class="absolute -top-1 -right-1 text-[11px] bg-yellow-500 text-white rounded-full w-5 h-5 flex items-center justify-center font-semibold cart-count">
                0
            </span>
            <span class="sr-only">items in cart, view bag</span>
        </button>
    </div>
</div>

<div id="mobile-menu"
    class="h-screen fixed top-0 left-0 z-50 bg-white w-full sm:px-10 flex flex-col -translate-x-full transition-all duration-300 ease-in-out lg:hidden shadow-lg">

    <div class="w-full flex justify-between p-4 border-b">
        <a href="/" class="flex items-center gap-2">
            <img class="h-10 w-auto object-contain" src="{{ $logo ?? '/images/logo.png' }}" alt="Logo">
        </a>
        <button onclick="closeMobileMenu()" type="button" class="text-gray-600 hover:text-gray-900 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="w-full h-full overflow-y-auto py-6 px-5 space-y-10">
        <!-- Search Section -->
        {{-- <div class="space-y-4">
            <select id="search-categories-mobile" name="search-categories"
                class="w-full rounded-md border border-gray-300 py-2 px-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-blue-300 focus:outline-none">
                <option value="">Tutti</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->codice }}">{{ $item->nome }}</option>
                @endforeach
            </select>

            <div class="relative">
                <input type="text" name="search" id="search-text-mobile"
                    class="w-full rounded-md border border-gray-300 py-2 px-3 pr-10 text-gray-800 shadow-sm focus:ring-2 focus:ring-blue-300 focus:outline-none"
                    placeholder="Ricerca prodotto...">
                <button type="button" onclick="handleSearchMobile()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-600 transition">
                    <x-lucide-search />
                </button>
            </div>
        </div> --}}

        <nav class="flex flex-col items-start gap-4">
            <a href="/" class="text-lg font-medium uppercase text-gray-700 hover:text-blue-600 transition">Home</a>
            <a href="{{ route('app.products') }}"
                class="text-lg font-medium uppercase text-gray-700 hover:text-blue-600 transition">Prodotti</a>
            <a href="/agency"
                class="text-lg font-medium uppercase text-gray-700 hover:text-blue-600 transition">Chi siamo</a>
            <a href="/news"
                class="text-lg font-medium uppercase text-gray-700 hover:text-blue-600 transition">Notizie</a>
            <a href="{{ route('app.contact') }}"
                class="text-lg font-medium uppercase text-gray-700 hover:text-blue-600 transition">Contatti</a>

            <!-- Auth Buttons -->
            <div class="pt-4 border-t border-gray-200 w-full space-y-2">
                @if (!$user)
                    <div class="w-full">
                        <a href="{{ route('app.login') }}" class="block w-full">
                            <x-secondary-button class="w-full justify-center items-center gap-3">
                                Accedi <x-mdi-login-variant class="w-4 h-4" />
                            </x-secondary-button>
                        </a>
                    </div>

                    <div class="w-full">
                        <a href="{{ route('app.register') }}" class="block w-full">
                            <x-primary-button class="w-full justify-center gap-3 items-center">
                                Registrati <x-heroicon-s-user-plus class="w-4 h-4" />
                            </x-primary-button>
                        </a>
                    </div>
                @elseif ($user->role != 1)
                    <div class="w-full">
                        <a href="/account/summary" class="block w-full">
                            <x-secondary-button class="w-full justify-center gap-3 items-center">
                                Account <x-heroicon-s-user-circle class="w-4 h-4" />
                            </x-secondary-button>
                        </a>
                    </div>

                    <form action="{{ route('app.logout') }}" method="POST" class="w-full">
                        @csrf
                        <x-danger-button type="submit" class="w-full justify-center gap-3 items-center">
                            Esci <x-mdi-logout class="w-4 h-4" />
                        </x-danger-button>
                    </form>
                @else
                    <div class="w-full">
                        <a href="/dashboard" class="w-full justify-center gap-3 items-center">
                            <x-secondary-button class="w-full justify-center">
                                Dashboard <x-mdi-view-dashboard-outline class="w-4 h-4" />
                            </x-secondary-button>
                        </a>
                    </div>
                @endif
            </div>
        </nav>
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
