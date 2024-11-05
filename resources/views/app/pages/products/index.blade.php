@section('title', 'Products')
<x-app-guest-layout>
    {{-- @dd($breadcrumbs) --}}
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'Shop']">
        <div class="w-full">

            <div
                class="py-2 flex sm:items-center items-start sm:justify-end justify-center flex-col sm:flex-row sm:gap-5 gap-2">
                <div class="sm:flex items-center gap-4 hidden">
                    <button onclick="setProductView('grid')"><x-ri-layout-grid-fill
                            class="w-5 h-5 text-gray-900" /></button>
                    <button onclick="setProductView('list')"><x-ri-list-check-2 class="w-5 h-5 text-gray-600" /></button>
                </div>
                <span class="hidden sm:block">|</span>
                <div class="flex items-center gap-2">
                    <label for="order_by" class="text-sm">Ordina per</label>
                    <select name="" id="order_by" class="text-sm py-1 rounded-md">
                        <option value="default">default</option>
                        <option value="asc">nome (A-Z)</option>
                        <option value="desc">nome (Z-A)</option>
                        {{-- <option value="price_low">Low to high (price)</option>
                        <option value="price_high">High to low (price)</option> --}}
                    </select>
                </div>
                <span class="hidden sm:block">|</span>
                <div class="flex items-center gap-2">
                    <label for="items_per_page" class="text-sm">Per page</label>
                    <select name="" id="items_per_page" class="text-sm py-1 rounded-md">
                        <option value="12">12</option>
                        <option value="2">2 (Test)</option>
                        <option value="20">20</option>
                        <option value="28">28</option>
                    </select>
                </div>
            </div>

            <div class="w-full block" id="grid">
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @if (!$products->isEmpty())
                        @foreach ($products as $item)
                            @include('app.components.Home.products.Partials.product-item', [
                                'product' => $item,
                            ])
                        @endforeach
                    @else
                        <h2 class="text-gray-300 font-bold text-2xl">Nessun prodotto trovato.</h2>
                    @endif
                </div>
            </div>

            <div class="w-full hidden" id="list">
                <div class="mt-6 space-y-4">
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
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                        items
                    </p>
                @endif

                @if ($products->hasPages())
                    <ul class="flex items-center gap-3 m-0 p-0">
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
        urlHref += order_by ? "order_by=" + order_by + '&' : "";

        if (itemPerPage != '12') {
            urlHref += itemPerPage ? "limit=" + itemPerPage + '&' : "";
            window.location.href = urlHref.slice(0, -1);
        } else {
            window.location.href = urlHref.slice(0, -1);
        }

    })

    if (order_by) orderByElement.value = order_by;
    if (limit) itemPerPageElement.value = limit;
</script>
