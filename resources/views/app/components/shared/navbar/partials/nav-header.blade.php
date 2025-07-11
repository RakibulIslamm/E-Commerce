<?php

$logo = null;


if (isset(tenant()?->brand_info)) {
    $brand_info = tenant()?->brand_info;
    $logo = isset($brand_info['logo']) ? $brand_info['logo'] : null;
    $logo_height = isset($brand_info['logo_height']) ? $brand_info['logo_height'] : '56';
}

?>


<div class="px-20 bg-white w-full hidden lg:block">
    <div class="flex items-center justify-center gap-10 w-full border-b py-3">
        <div>
            <a href="/" class="flex items-center gap-2">
                <img class="h-12 w-auto object-cover" style="height: {{ $logo_height }}px"
                    src="{{ $logo ?? '/images/logo.png' }}" alt="">
                {{-- <h2 class="text-lg font-bold">Company Name</h2> --}}
            </a>
        </div>


        <div class="relative grow flex items-center justify-end">
            <div {{-- translate-x-0 visible --}}
                class="flex items-center relative transition-all ease-in-out duration-300 delay-500">
                <label for="search-categories" class="sr-only">Categories</label>
                <select id="search-categories" name="search-categories"
                    class="relative rounded-l-md text-gray-900 border border-r-0 border-gray-200 outline-none
                      focus:outline-blue-300 focus:outline-2 focus:-outline-offset-2 focus:z-10 appearance-none max-w-[200px]">
                    <option value="" class="px-2 py-1">Tutti</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->codice }}" class="px-2 py-1">{{ $item->nome }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" name="search" id="search-text" class="relative grow rounded-r-md py-2 pl-3 pr-8 text-gray-900 border border-gray-200 outline-none
                      focus:outline-blue-300 focus:outline-2 focus:-outline-offset-2 focus:z-10"
                onkeydown="if (event.key === 'Enter') { handleSearch(); event.preventDefault(); }"
                placeholder="Ricerca prodotto...">

            <button onclick="handleSearch()">
                <x-lucide-search
                    class="w-7 h-7 absolute right-2 top-1/2 -translate-y-1/2 z-50 text-gray-500 cursor-pointer transition-all ease-in-out duration-100"
                    id="search-icon-show" />
            </button>
        </div>

        <div class="flex items-center gap-8">
            <button class="group -m-2 flex items-center p-2 relative text-gray-500" onclick="openCart()">
                <x-lucide-shopping-cart class="w-7 h-7" />
                <span
                    class=" absolute top-0 right-0 text-xs group-hover:text-gray-800 bg-yellow-500 text-white rounded-full w-5 h-5 flex items-center justify-center cart-count">0</span>
                <span class="sr-only">items in cart, view bag</span>
            </button>
            <div class="flex items-center gap-3">
                @if (!$user)
                    <div class="flex items-center gap-3">
                        <a href="/login" class="text-sm font-medium text-gray-700 hover:text-gray-800">Accedi</a>
                        <span class="h-6 w-px bg-gray-200"></span>
                        <a href="/register" class="text-sm font-medium text-gray-700 hover:text-gray-800">Registrati</a>
                    </div>
                @endif
                @if ($user && $user->role != 1)
                    <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                        <a href="/account/summary" class="text-sm font-medium text-gray-700 hover:text-gray-800">Account</a>
                        <form action="{{ route('app.logout') }}" method="post">
                            @csrf
                            <button type="submit">
                                Esci
                            </button>
                        </form>
                    </div>
                @endif
                @if ($user && $user->role == 1)
                    <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                        <a href="/dashboard" class="text-sm font-medium text-gray-700 hover:text-gray-800">Dashboard</a>
                    </div>
                @endif
                <div>
                    <div id="google_translate_element" style="display:none;"></div>

                    <select id="language-select" onchange="translatePage(this.value)" style="
    padding: 6px 30px 6px 45px; 
    background-repeat: no-repeat; 
    background-position: 10px center; 
    background-size: 30px 20px;
    font-size: 16px;
  ">
                        <option value="it" data-flag="https://flagcdn.com/w40/it.png">Italiano</option>
                        <option value="en" data-flag="https://flagcdn.com/w40/gb.png">English</option>
                        <option value="zh-CN" data-flag="https://flagcdn.com/w40/cn.png">中文</option>
                    </select>

                    <script>
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'it',
                                includedLanguages: 'it,en,zh-CN',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, 'google_translate_element');
                        }

                        function setCookie(name, value, days) {
                            let expires = "";
                            if (days) {
                                const date = new Date();
                                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                                expires = "; expires=" + date.toUTCString();
                            }
                            document.cookie = name + "=" + (value || "") + expires + "; path=/";
                        }

                        function translatePage(lang) {
                            if (lang === 'it') {
                                setCookie('googtrans', '/', -1);
                                location.reload();
                            } else {
                                setCookie('googtrans', `/it/${lang}`, 1);
                                location.reload();
                            }
                        }

                        function updateFlag() {
                            const select = document.getElementById('language-select');
                            const selectedOption = select.options[select.selectedIndex];
                            const flagUrl = selectedOption.getAttribute('data-flag');
                            select.style.backgroundImage = `url(${flagUrl})`;
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            updateFlag();
                            document.getElementById('language-select').addEventListener('change', updateFlag);
                        });
                    </script>

                    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const categoryElement = document.getElementById('search-categories');
    const searchTextElement = document.getElementById('search-text');

    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    const category = params.get('category');
    const search = params.get('search');
    const query = params.get('query');
    const order_by = params.get('order_by');
    const limit = params.get('limit');
    let urlHref = '/products?';

    function handleSearch() {
        const category = categoryElement?.value;
        const searchText = searchTextElement?.value;

        urlHref += category ? "category=" + category + '&' : "";
        urlHref += searchText ? "search=" + searchText + '&' : "";
        urlHref += order_by ? "order_by=" + order_by + '&' : "";
        urlHref += limit ? "limit=" + limit + '&' : "";

        window.location.href = urlHref.slice(0, -1);

        // if (category || searchText) {
        //     window.location.href = (searchText && category) ?
        //         `/products?category=${category ? category : ''}&search=${searchText ? searchText : ''}` : search ?
        //         `/products?search=${searchText ? searchText : ''}` : `/products?category=${category ? category : ''}`;
        // } else {
        //     window.location.href = "/products";
        // }
    }

    if (category) {
        categoryElement.value = category;
        if (!categoryElement.value) categoryElement.value = ""
    }

    if (search) searchTextElement.value = search;
</script>