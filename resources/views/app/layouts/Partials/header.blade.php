<div class="flex justify-between items-center">

    <h2 class="text-xl font-semibold">@yield('title')</h2>
    <div class="flex items-center gap-3">
        <div class="relative">
            <x-text-input id="search" class="block w-full py-1" type="text" name="search" placeholder="Ricerca..." />
            <x-bx-search-alt class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-600" />
        </div>
        <button class="flex items-center gap-1 text-gray-600"><x-heroicon-c-user class="w-5 h-5" /> Esci</button>
    </div>
</div>
