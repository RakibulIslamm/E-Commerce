<div class="group/product relative">
    <div class="aspect-h-1 aspect-w-1 w-full min-h-[250px] overflow-hidden bg-gray-200 relative rounded-md">
        <div
            class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent to-70% opacity-60 group-hover/product:opacity-100 group-hover/product:to-[#00000049] transition-opacity ease-in-out duration-300">
        </div>
        <img src="{{ $product->FOTO ? 'data:image/png;base64,' . $product->FOTO : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}"
            alt="" class="h-full w-full object-cover object-center">
        <div class=" absolute top-0 left-0 w-full h-full flex flex-col justify-between items-center">
            <div class="w-full flex items-center justify-between mt-3">
                <p
                    class="px-4 py-1 rounded-r bg-yellow-700 text-white text-xs group-hover/product:border group-hover/product:border-l-0">
                    New arrieval</p>
                @if (isset($section))
                @endif
                <button class="px-4 py-1 group/wish-list text-red-500 cursor-pointer ml-auto" title="Add to wishlist">
                    <x-heroicon-o-heart class="w-6 h-6 group-hover/wish-list:hidden group-hover/product:text-white" />
                    <x-heroicon-s-heart class="w-6 h-6 hidden group-hover/wish-list:block " />
                </button>
            </div>
            <div
                class="flex flex-col items-center gap-2 invisible opacity-0 group-hover/product:opacity-100 group-hover/product:visible transition-all ease-in-out">
                <button
                    class="px-5 py-1 text-sm bg-yellow-300 active:bg-yellow-100 text-gray-900 rounded flex items-center gap-2"><x-lucide-shopping-cart
                        class="w-5 h-5" /> Add</button>
                <button class="px-5 py-1 text-sm bg-blue-700 active:bg-blue-500 text-white rounded">Buy Now</button>
            </div>
            <div class="w-full flex items-center justify-between">
                <div class="px-4 mb-3">
                    {{-- @dd($product['DESCRIZIONEBREVE']) --}}
                    <a href="#">
                        <h3
                            class="font-semibold text-slate-100 group-hover/product:text-white drop-shadow-xl line-clamp-1 flex-1">
                            {{ $product['DESCRIZIONEBREVE'] }}
                        </h3>
                    </a>
                    <div class="flex items-center gap-1 text-yellow-400">
                        <x-heroicon-m-star class="w-4 h-4" />
                        <x-heroicon-m-star class="w-4 h-4" />
                        <x-heroicon-m-star class="w-4 h-4" />
                        <x-heroicon-m-star class="w-4 h-4" />
                        <x-heroicon-m-star class="w-4 h-4" />
                    </div>
                </div>
                <h3 class="font-semibold text-slate-100 group-hover/product:text-white drop-shadow-xl px-4">
                    {{ $product['PRE1IMP'] }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- <div class="group relative max-w-[280] h-[300px] bg-slate-400">
    <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg"
        class="w-full h-full object-cover object-center" alt="">
</div> --}}
