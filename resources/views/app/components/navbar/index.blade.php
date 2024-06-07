<div class="flex h-16 items-center justify-between gap-10 px-20 bg-white">
    <div class="ml-4 flex lg:ml-0">
        <a href="/" class="flex items-center gap-2">
            <img class="h-12 w-auto object-cover" src="/images/logo.png" alt="">
            <h2 class="text-lg font-bold">Company Name</h2>
        </a>
    </div>

    <div class="ml-auto flex items-center gap-12">

        <div class="flex items-center gap-5">
            <div class="flex items-center">
                <input type="text" class="border rounded-lg w-[500px] transition-all ease-in-out">
                <button class="p-2 text-gray-500">
                    <span class="sr-only">Search</span>
                    <x-lucide-search class="w-7 h-7" />
                </button>
            </div>
            <button class="group -m-2 flex items-center p-2 relative text-gray-500">
                <x-lucide-shopping-cart class="w-7 h-7" />
                <span
                    class=" absolute top-0 right-0 text-xs group-hover:text-gray-800 bg-yellow-500 text-white rounded-full w-5 h-5 flex items-center justify-center">9+</span>
                <span class="sr-only">items in cart, view bag</span>
            </button>
        </div>

        <div class="flex items-center gap-3">
            @if (!$user)
                <div class="flex items-center gap-3">
                    <a href="/login" class="text-sm font-medium text-gray-700 hover:text-gray-800">Sign
                        in</a>
                    <span class="h-6 w-px bg-gray-200"></span>
                    <a href="/register" class="text-sm font-medium text-gray-700 hover:text-gray-800">Create
                        account</a>
                </div>
            @endif
            @if ($user)
                <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                    <a href="/dashboard" class="text-sm font-medium text-gray-700 hover:text-gray-800">Dashboard</a>
                    <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                </div>
            @endif
        </div>
    </div>

</div>
<div class="sticky top-0 z-50">
    <header class="relative">
        <nav aria-label="Top">
            <div class="bg-blue-900 w-full px-20 text-white">
                <div class="flex h-16 items-center gap-10">
                    <div class="self-stretch">
                        <div class="flex items-center h-full space-x-8">
                            <div>
                                <button type="button"
                                    class="flex items-center gap-2 uppercase font-semibold px-3 py-2 border rounded"
                                    aria-expanded="false"><x-lucide-menu class="w-5 h-5" /> Categories</button>
                            </div>
                            <div class="flex items-center h-full space-x-8">
                                <a href="#" class="flex items-center text-sm font-medium">Home</a>
                                <a href="#" class="flex items-center text-sm font-medium">Products</a>
                                <a href="#" class="flex items-center text-sm font-medium">Agency</a>
                                <a href="#" class="flex items-center text-sm font-medium">News</a>
                                <a href="#" class="flex items-center text-sm font-medium">Contact</a>
                            </div>
                        </div>
                    </div>

                    {{-- Right --}}

                </div>
            </div>
        </nav>
    </header>
</div>






{{-- 

<div class="flex group/mega">
                                <div class="relative flex">
                                    <button type="button"
                                        class="border-transparent text-gray-700 hover:text-gray-800 relative z-10 -mb-px flex items-center border-b-2 pt-px text-sm font-medium transition-colors duration-200 ease-out"
                                        aria-expanded="false">Categories</button>
                                </div>
                                <div
                                    class="absolute top-20 text-sm text-gray-500 overflow-hidden invisible opacity-0 group-hover/mega:visible group-hover/mega:top-16 group-hover/mega:opacity-100 overflow-y-auto transition-all ease-in-out duration-300">
                                    <div class="p-5 bg-gray-100 rounded">
                                        <p class="px-4 py-2 hover:bg-gray-200 rounded">Category 1</p>
                                        <p class="px-4 py-2 hover:bg-gray-200 rounded">Category 2</p>
                                        <p class="px-4 py-2 hover:bg-gray-200 rounded">Category 3</p>
                                        <p class="px-4 py-2 hover:bg-gray-200 rounded">Category 4</p>
                                        <p class="px-4 py-2 hover:bg-gray-200 rounded">Category 5</p>
                                    </div>
                                </div>
                            </div>
--}}
