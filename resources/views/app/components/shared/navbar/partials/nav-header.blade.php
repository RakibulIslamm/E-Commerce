<?php

$logo = null;

// dd($site_settings);

if (isset($site_settings->brand_info)) {
    $brand_info = $site_settings->brand_info;

    $logo = isset($brand_info['logo']) ? $brand_info['logo'] : null;
}

?>


<div class="px-20 bg-white w-full">
    <div class="h-[80px] flex items-center justify-center gap-10 w-full border-b">
        <div>
            <a href="/" class="flex items-center gap-2">
                <img class="h-12 w-auto object-cover" src="{{ $logo ?? '/images/logo.png' }}" alt="">
                {{-- <h2 class="text-lg font-bold">Company Name</h2> --}}
            </a>
        </div>


        <div class="relative grow flex items-center justify-end">
            <div {{-- translate-x-0 visible --}}
                class="flex items-center relative transition-all ease-in-out duration-300 delay-500">
                <label for="search-categories" class="sr-only">Categories</label>
                <select id="search-categories" name="search-categories"
                    class="relative rounded-l-md py-2 pl-2 pr-7 text-gray-900 border border-r-0 border-gray-200 outline-none
                      focus:outline-blue-300 focus:outline-2 focus:-outline-offset-2 focus:z-10 appearance-none">
                    <option class="px-2 py-1">All</option>
                    @foreach ($categories as $item)
                        <option class="px-2 py-1">{{ $item->nome }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" name="search" id="search"
                class="relative grow rounded-r-md py-2 pl-3 pr-8 text-gray-900 border border-gray-200 outline-none
                      focus:outline-blue-300 focus:outline-2 focus:-outline-offset-2 focus:z-10"
                placeholder="Search Product...">

            <x-lucide-search
                class="w-7 h-7 absolute right-2 top-1/2 -translate-y-1/2 z-50 text-gray-500 cursor-pointer transition-all ease-in-out duration-100"
                id="search-icon-show" />
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
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
