<div class="sticky top-0 z-50 hidden lg:block" id="main-menu-container">
    <header class="relative">
        <nav aria-label="Top">
            <div class="bg-white w-full px-20 text-gray-700 border-b">
                <div class="flex h-16 items-center justify-between gap-10">
                    <div class="flex-1">
                        <div class="flex items-center h-full">
                            <div class="relative mr-10">
                                <button type="button" id="categories-btn"
                                    class="flex items-center gap-2 font-semibold py-2"><x-lucide-layout-dashboard
                                        class="w-5 h-5" /> All
                                    Categories <x-ri-arrow-drop-down-fill class="w-5 h-5" /></button>
                                {{-- top-[55px] visible opacity-1 --}}
                                <div class="absolute top-[70px] invisible opacity-0 left-0 text-sm text-gray-500 overflow-hidden transition-all ease-in-out duration-300 shadow"
                                    id="category-list">
                                    <div class="bg-white min-w-[200px]">
                                        @if (!$categories->isEmpty())
                                            @foreach ($categories as $item)
                                                <a href="products?category={{ $item->id }}"
                                                    class="px-4 py-3 hover:bg-gray-200 text-lg block {{ !$loop->last ? 'border-b' : '' }}">{{ $item->nome }}</a>
                                            @endforeach
                                        @else
                                            <p>Category Not found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center h-full space-x-8">
                                <a href="/" class="flex items-center text-sm font-medium">Home</a>
                                <a href="{{ route('app.products') }}"
                                    class="flex items-center text-sm font-medium">Products</a>
                                <a href="/agency" class="flex items-center text-sm font-medium">Agency</a>
                                <a href="/news" class="flex items-center text-sm font-medium">News</a>
                                <a href="{{ route('app.contact') }}"
                                    class="flex items-center text-sm font-medium">Contact</a>
                            </div>
                        </div>
                    </div>

                    <div id="main-menu-cart-button" class="hidden">
                        <button class="group -m-2 flex items-center p-2 relative text-gray-500" onclick="openCart()">
                            <x-lucide-shopping-cart class="w-7 h-7" />
                            <span
                                class=" absolute top-0 right-0 text-xs group-hover:text-gray-800 bg-yellow-500 text-white rounded-full w-5 h-5 flex items-center justify-center cart-count">0</span>
                            <span class="sr-only">items in cart, view bag</span>
                        </button>
                    </div>

                </div>
            </div>
        </nav>
    </header>
</div>


<script>
    const categoriesButton = document.getElementById('categories-btn')
    const categoryList = document.getElementById('category-list')

    categoriesButton.addEventListener('click', () => {
        categoryList.classList.toggle('top-[70px]')
        categoryList.classList.toggle('invisible')
        categoryList.classList.toggle('opacity-0')
        categoryList.classList.toggle('top-[53px]')
        categoryList.classList.toggle('visible')
        categoryList.classList.toggle('opacity-1')
    })

    document.addEventListener('click', (event) => {
        const target = event.target;
        if (!categoryList.contains(target) && !categoriesButton.contains(target)) {
            categoryList.classList.add('top-[70px]', 'invisible', 'opacity-0')
            categoryList.classList.remove('top-[53px]', 'visible', 'opacity-1')
        }
    });

    document.addEventListener('scroll', function() {
        if (window.pageYOffset > 105) {
            document.getElementById('main-menu-cart-button').classList.remove('hidden')
        } else {
            document.getElementById('main-menu-cart-button').classList.add('hidden')
        }
    })
</script>
