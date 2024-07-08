<div class="sticky top-0 z-50">
    <header class="relative">
        <nav aria-label="Top">
            <div class="bg-white w-full px-20 text-gray-700 border-b">
                <div class="flex h-16 items-center gap-10">
                    <div class="self-stretch">
                        <div class="flex items-center h-full">
                            <div class="relative mr-10">
                                <button type="button" id="categories-btn"
                                    class="flex items-center gap-2 font-semibold py-2"><x-lucide-layout-dashboard
                                        class="w-5 h-5" /> All
                                    Categories <x-ri-arrow-drop-down-fill class="w-5 h-5" /></button>
                                {{-- top-[55px] visible opacity-1 --}}
                                <div class="absolute top-[70px] invisible opacity-0 left-0 text-sm text-gray-500 overflow-hidden transition-all ease-in-out duration-300 shadow rounded-md"
                                    id="category-list">
                                    <div class="p-3 bg-white rounded-md space-y-2 min-w-[200px]">
                                        @foreach ($categories as $item)
                                            <a href="#"
                                                class="px-4 py-2 hover:bg-gray-200 rounded text-lg block">{{ $item->nome }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center h-full space-x-8">
                                <a href="/" class="flex items-center text-sm font-medium">Home</a>
                                <a href="#" class="flex items-center text-sm font-medium">Products</a>
                                <a href="#" class="flex items-center text-sm font-medium">Agency</a>
                                <a href="#" class="flex items-center text-sm font-medium">News</a>
                                <a href="{{ route('app.contact') }}"
                                    class="flex items-center text-sm font-medium">Contact</a>
                            </div>
                        </div>
                    </div>

                    {{-- Right --}}

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
        categoryList.classList.toggle('top-[55px]')
        categoryList.classList.toggle('visible')
        categoryList.classList.toggle('opacity-1')
    })

    document.addEventListener('click', (event) => {
        const target = event.target;
        if (!categoryList.contains(target) && !categoriesButton.contains(target)) {
            categoryList.classList.add('top-[70px]', 'invisible', 'opacity-0')
            categoryList.classList.remove('top-[55px]', 'visible', 'opacity-1')
        }
    });
</script>
