@section('title', 'Shopping Cart')
<x-app-guest-layout>

    <x-page-layout :props="['title' => 'Shopping Cart', 'breadcrumbs' => $breadcrumbs]">
        <div class="flex items-start lg:flex-row flex-col gap-4">
            <div class="lg:flex-1 w-full" id="cart-page-container">
                <p class="hidden text-3xl font-bold text-gray-300" id="cart-page-loading">Loading...</p>
            </div>
            <!-- Sub total -->
            <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md lg:block lg:w-[400px] w-full">
                <div class="mb-2 flex justify-between">
                    <p class="text-gray-700">Subtotal</p>
                    <p class="text-gray-700">$
                        <span id="sub-total">0.00</span>
                    </p>
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-700">Vat</p>
                    <p class="text-gray-700">$
                        <span id="vat">0.00</span>
                    </p>
                </div>
                <hr class="my-4" />
                <div class="flex justify-between">
                    <p class="text-lg font-bold">Total</p>
                    <div class=" flex flex-col items-end">
                        <p class="mb-1 text-lg font-bold">$
                            <span id="total">0.00</span>
                        </p>
                        {{-- <p class="text-sm text-gray-700">including VAT</p> --}}
                    </div>
                </div>
                @php
                    $cart = session()->get('cart');
                @endphp
                @if (isset($cart) and count($cart) > 0)
                    <form action="{{ route('app.checkout') }}" method="POST">
                        @csrf
                        <button
                            class="block mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 text-center hover:bg-blue-600">Check
                            out</button>
                    </form>
                @else
                    <button disabled
                        class="block mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 text-center hover:bg-blue-600 disabled:bg-gray-300 disabled:text-gray-900 cursor-not-allowed">Check
                        out</button>
                @endif
            </div>
        </div>
    </x-page-layout>
</x-app-guest-layout>
<script>
    getCart('cart-page-loading')

    function updateQuantity(id, quantity) {
        console.log(`Updating server with quantity ${quantity} for product ${id}`);
        quantitySpinUpdate(id, 'invisible');
        setTimeout(() => {
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: id,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        window.all_cart = data.cart_items;
                    }
                    quantitySpinUpdate(id, 'invisible');
                    render()
                })
                .catch(error => {
                    console.log(error);
                    quantitySpinUpdate(id, 'invisible');
                });
            console.log(`Server updated with quantity ${quantity} for product ${id}`);
        }, 1000);
    }

    const debouncedUpdateServer = debounce(updateQuantity, 1000);

    function updateQuantityDisplay(quantity, id) {
        document.getElementById(`cart-page-quantity-input-${id}`).value = quantity;
    }

    function cartIncrease(id) {
        let quantity = parseInt(document.getElementById(`cart-page-quantity-input-${id}`).value, 10) || 1;
        quantity++;
        updateQuantityDisplay(quantity, id);
        debouncedUpdateServer(id, quantity);
    }

    function cartDecrease(id) {
        let quantity = parseInt(document.getElementById(`cart-page-quantity-input-${id}`).value, 10) || 1;
        if (quantity > 1) {
            quantity--;
            updateQuantityDisplay(quantity, id);
            debouncedUpdateServer(id, quantity);
        }
    }
</script>
