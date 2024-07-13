<div id="cart-sidebar"
    class="w-[400px] h-screen z-50 transform translate-x-full fixed top-0 right-0 bg-slate-50 transition-all ease-in-out duration-300 flex flex-col justify-between">

    <div class="flex items-start justify-between p-3">
        <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
        <div class="ml-3 flex h-7 items-center">
            <button onclick="closeCart()" type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                <span class="absolute -inset-0.5"></span>
                <span class="sr-only">Close panel</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="pr-8 pl-6 flex-1 overflow-hidden overflow-y-auto">
        <ul class="divide-y divide-gray-200 space-y-3" id="cart-container">

        </ul>
    </div>

    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
        <div class="flex justify-between text-base font-medium text-gray-900">
            <p>Subtotal</p>
            <p>$
                <span id="sidebar-subtotal">0.00</span>
            </p>
        </div>
        <div class="mt-6">
            <a href="/cart"
                class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Go
                to Cart</a>
        </div>
    </div>
</div>
