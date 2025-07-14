@section('title', 'Prodotti')
{{-- @dd($products) --}}
<x-app-guest-layout>
    {{-- @dd($breadcrumbs) --}}
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'Negozio']">
        <div class="w-full">
            <div class="flex flex-col-reverse lg:flex-row lg:justify-between items-center gap-8 w-full">
                @if ($selectedCategory?->nome)
                    <h2 class="break-keep text-xl font-semibold px-5 py-2 rounded-lg bg-gray-200">{{$selectedCategory?->nome}}</h2>
                @endif
                <div
                    class="py-2 flex-1 flex lg:items-center items-start lg:justify-end justify-center flex-col lg:flex-row lg:gap-5 gap-2 w-full">
                    <div class="sm:flex items-center gap-4 hidden">
                        <button onclick="setProductView('grid')"><x-ri-layout-grid-fill
                                class="w-5 h-5 text-gray-900" /></button>
                        <button onclick="setProductView('list')"><x-ri-list-check-2 class="w-5 h-5 text-gray-600" /></button>
                    </div>
                    <span class="hidden lg:block">|</span>
                    <div class="flex items-center gap-2">
                        <label for="order_by" class="text-sm">Ordina per</label>
                        <select name="" id="order_by" class="text-sm py-1 rounded-md">
                            <option value="default">predefinito</option>
                            <option value="asc">nome (A-Z)</option>
                            <option value="desc">nome (Z-A)</option>
                            <option value="price_low">Dal più basso al più alto (prezzo)</option>
                            <option value="price_high">Dal più alto al più basso (prezzo)</option>
                        </select>
                    </div>
                    <span class="hidden lg:block">|</span>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                        <label for="items_per_page" class="text-sm">Risultati per pagina</label>
                            <select name="" id="items_per_page" class="text-sm py-1 rounded-md">
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="lg:hidden">
                            <button id="open-modal-btn" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'search-product')"
                                class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded cursor-pointer"
                                type="button">
                                <x-lucide-search class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <x-modal name="search-product">
                <div class="space-y-2 p-4">
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
                            <x-lucide-search class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </x-modal>
            
            <div class="w-full block" id="grid">
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @if (!$products->isEmpty())
                        @foreach ($products as $item)
                            @include('app.components.Home.products.Partials.product-item', [
                                'product' => $item,
                            ])
                        @endforeach
                    @endif
                </div>
                @if ($products->isEmpty())
                    <h2 class="text-gray-300 font-semibold text-2xl w-full py-10 text-center">Nessun prodotto trovato.</h2>
                @endif
            </div>

            <div class="w-full hidden" id="list">
                <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-5">
                    @if (!$products->isEmpty())
                        @foreach ($products as $item)
                            @include('app.components.Home.products.Partials.product-item-list', [
                                'product' => $item,
                            ])
                        @endforeach
                    @else
                        <h2 class="text-gray-300 font-bold text-2xl">Nessun prodotto trovato.</h2>
                    @endif
                </div>
            </div>

            <div class="py-5 space-y-3">
                @if ($products->total() > 0)
                    <p>
                    Visualizzazione da {{ $products->firstItem() }} a {{ $products->lastItem() }} di {{ $products->total() }}
                        elementi
                    </p>
                @endif

                @if ($products->hasPages())
                    <ul class="flex items-center flex-wrap gap-3 m-0 p-0">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="py-1 px-3">
                                <x-ri-arrow-left-double-fill class="w-5 h-5 text-gray-400" />
                            </li>
                        @else
                            <li><a class="" href="{{ $products->appends(request()->all())->previousPageUrl() }}"
                                    rel="prev"><x-ri-arrow-left-double-fill class="w-5 h-5" /></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($products->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            {{-- @if (is_string($element))
                            <li class="disabled"><span>{{ $element }}</span></li>
                        @endif --}}

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="text-gray-400 py-1 px-1"><span>{{ $page }}</span></li>
                                    @else
                                        <li class="text-gray-900"><a class="py-1 px-3 border"
                                                href="{{ $products->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach


                        @if ($products->hasMorePages())
                            <li class=" text-gray-900"><a
                                    href="{{ $products->appends(request()->all())->nextPageUrl() }}" rel="next">
                                    <x-ri-arrow-right-double-fill class="w-5 h-5" />
                                </a></li>
                        @else
                            <li class="">
                                <x-ri-arrow-right-double-fill class="w-5 h-5 text-gray-400" />
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </x-page-layout>
</x-app-guest-layout>

<script>
    const orderByElement = document.getElementById('order_by');
    const itemPerPageElement = document.getElementById('items_per_page');

    const gridItem = document.getElementById('grid');
    const listItem = document.getElementById('list');

    const categoryElementMobie = document.getElementById('search-categories-mobile');
    const searchTextElementMobie = document.getElementById('search-text-mobile');

    function renderProductView() {
        const productView = localStorage.getItem('product_view');
        // console.log(productView);
        if (productView == 'list') {
            gridItem.classList.remove('sm:block');
            gridItem.classList.add('sm:hidden');
            listItem.classList.remove('sm:hidden');
            listItem.classList.add('sm:block');
        } else {
            gridItem.classList.remove('sm:hidden');
            gridItem.classList.add('sm:block');
            listItem.classList.remove('sm:block');
            listItem.classList.add('sm:hidden');
        }
    }
    renderProductView();

    function setProductView(view) {
        localStorage.setItem('product_view', view);
        renderProductView();
    }


    orderByElement.addEventListener('change', () => {
        const category = categoryElement?.value;
        const searchText = searchTextElement?.value;
        const orderBy = orderByElement?.value;
        urlHref += category ? "category=" + category + '&' : "";
        urlHref += searchText ? "search=" + searchText + '&' : "";
        urlHref += query ? "query=" + query + '&' : "";
        urlHref += limit ? "limit=" + limit + '&' : "";
        if (orderBy != 'default') {
            urlHref += orderBy ? "order_by=" + orderBy + '&' : "";
            window.location.href = urlHref.slice(0, -1);
        } else {
            window.location.href = urlHref.slice(0, -1);
        }
    })
    itemPerPageElement.addEventListener('change', () => {
        const category = categoryElement?.value;
        const searchText = searchTextElement?.value;
        const itemPerPage = itemPerPageElement?.value;
        urlHref += category ? "category=" + category + '&' : "";
        urlHref += searchText ? "search=" + searchText + '&' : "";
        urlHref += query ? "query=" + query + '&' : "";
        urlHref += order_by ? "order_by=" + order_by + '&' : "";

        if (itemPerPage != '12') {
            urlHref += itemPerPage ? "limit=" + itemPerPage + '&' : "";
            window.location.href = urlHref.slice(0, -1);
        } else {
            window.location.href = urlHref.slice(0, -1);
        }

    })

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

        console.log(category);
        console.log(searchText);


        urlHrefMobie += category ? "category=" + category + '&' : "";
        urlHrefMobie += searchText ? "search=" + searchText + '&' : "";
        urlHrefMobie += order_byMobie ? "order_by=" + order_byMobie + '&' : "";
        urlHrefMobie += limitMobie ? "limit=" + limitMobie + '&' : "";

        window.location.href = urlHrefMobie.slice(0, -1);
    }

    if (order_by) orderByElement.value = order_by;
    if (limit) itemPerPageElement.value = limit;
    if (categoryMobie) categoryElementMobie.value = categoryMobie;
    if (searchMobie) searchTextElementMobie.value = searchMobie;
</script>
