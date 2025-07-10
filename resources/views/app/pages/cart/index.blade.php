@section('title', 'Shopping Cart')
{{-- @dd($shipping_setting) --}}
<x-app-guest-layout>

    <x-page-layout :props="['title' => 'Shopping Cart', 'breadcrumbs' => $breadcrumbs]">
        
        @if ($shipping_setting)
            <p id="shipping-limit-p" class="font-semibold text-red-800 bg-red-200 py-1 px-3 rounded-md mb-5 lg:-mt-10">
                {{-- Limite minimo di ordine: {{$shipping_setting->minimum_order}}€ --}}
            </p>
        @else
            <p class="font-semibold text-red-800 bg-red-200 py-1 px-3 rounded-md mb-5 lg:-mt-10">
                Non ci sono metodi di spedizione disponibili su questa piattaforma.
            </p>
        @endif
        
        @if (session('error'))
        <div class="bg-red-100 text-red-700 border-l-4 border-red-500 p-2 lg:-mt-4 mb-4 rounded-r-lg">
            <strong>{{ session('error') }}</strong>
        </div>
        @endif
        <div class="flex items-start lg:flex-row flex-col gap-4">
            <div class="lg:flex-1 w-full" id="cart-page-container">
                <p class="hidden text-3xl font-bold text-gray-300" id="cart-page-loading">Loading...</p>
            </div>
            <!-- Sub total -->
            <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md lg:block lg:w-[400px] w-full">
                <div class="mb-2 flex justify-between">
                    <p class="text-gray-700">Subtotale</p>
                    <p class="text-gray-700">€
                        <span id="sub-total">0.00</span>
                    </p>
                </div>
                @if (!tenant()?->price_with_vat)
                    <div class="flex justify-between">
                        <p class="text-gray-700">Iva</p>
                        <p class="text-gray-700">€
                            <span id="vat">0.00</span>
                        </p>
                    </div> 
                @endif
                
                <hr class="my-4" />
                <div class="flex justify-between">
                    <p class="text-lg font-bold">Totale</p>
                    <div class=" flex flex-col items-end">
                        <p class="mb-1 text-lg font-bold">€
                            <span id="total">0.00</span>
                        </p>
                        {{-- <p class="text-sm text-gray-700">including VAT</p> --}}
                    </div>
                </div>
                @php
                    $cart = session()->get('cart');
                @endphp
                @if (isset($cart) and count($cart) > 0)
                    <a href="/cart/checkout"
                    class="block mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 text-center hover:bg-blue-600" id="proceed-to-checkout-btn">Procedi</a>
                @else
                    <button disabled
                        class="block mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 text-center hover:bg-blue-600 disabled:bg-gray-300 disabled:text-gray-900 cursor-not-allowed">Procedi</button>
                @endif
            </div>
        </div>
    </x-page-layout>
</x-app-guest-layout>
<script>
    
    async function cart (){
        await getCart('cart-page-loading');
        updateShippingLimit(window.all_cart);
    }
    cart();

    const shippingSetting = {
        minimumOrder: {{ $shipping_setting ? $shipping_setting->minimum_order : 0 }},
    };

    function updateShippingLimit(cartItems) {
        const shippingLimitP = document.getElementById('shipping-limit-p');
        
        // Calculate the total cart value
        const cartTotal = Object.values(cartItems).reduce((total, item) => {
            return total + (item.quantity * item.price);
        }, 0);
        
        // Update the shipping limit message based on the cart total
        if (shippingSetting.minimumOrder === 0) {
            shippingLimitP.className = "hidden"
        }
        if (cartTotal >= shippingSetting.minimumOrder) {
            shippingLimitP.className = "font-semibold bg-green-500 py-1 px-3 rounded-md mb-5 lg:-mt-10 flex items-center text-green-700 bg-opacity-50";
            shippingLimitP.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Limite minimo di ordine raggiunto: ${shippingSetting.minimumOrder}€
            `;
        } else if (shippingSetting.minimumOrder > 0) {
            shippingLimitP.className = "font-semibold text-red-800 bg-red-200 py-1 px-3 rounded-md mb-5 lg:-mt-10";
            shippingLimitP.innerHTML = `Limite minimo di ordine: ${shippingSetting.minimumOrder}€`;
        } else {
            shippingLimitP.className = "font-semibold text-red-800 bg-red-200 py-1 px-3 rounded-md mb-5 lg:-mt-10";
            shippingLimitP.innerHTML = "Non ci sono metodi di spedizione disponibili su questa piattaforma.";
        }
    }

    // function getCartTotal() {
    //     // Replace this with your actual cart total calculation logic
    //     return window.all_cart.reduce((total, item) => total + (item.quantity * item.price), 0);
    // }

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
                    // console.log(data.cart_items);
                    if (data.success) {
                        window.all_cart = data.cart_items;
                    }
                    else{
                        // alert(data.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                    updateShippingLimit(window.all_cart);
                    render()
                })
                .catch(error => {
                    console.log(error);
                    quantitySpinUpdate(id, 'invisible');
                });
            quantitySpinUpdate(id, 'invisible');
            console.log(`Server updated with quantity ${quantity} for product ${id}`);
        }, 1000);
    }

    const debouncedUpdateServer = debounce(updateQuantity, 1000);

    function updateQuantityDisplay(quantity, id) {
        document.getElementById(`cart-page-quantity-input-${id}`).value = quantity;
    }

    function cartIncrease(id, pxc=1) {
        let quantity = parseInt(document.getElementById(`cart-page-quantity-input-${id}`).value, 10) || 1;
        quantity += pxc;
        updateQuantityDisplay(quantity, id);
        debouncedUpdateServer(id, quantity);
    }

    function cartDecrease(id, pxc=1) {
        let quantity = parseInt(document.getElementById(`cart-page-quantity-input-${id}`).value, 10) || 1;
        if (quantity > 1) {
            quantity -= pxc;
            updateQuantityDisplay(quantity, id);
            debouncedUpdateServer(id, quantity);
        }
    }
</script>
