@section('title', 'Shopping Cart')
<x-app-guest-layout>
    {{-- @dd($cart_items); --}}
    <x-page-layout :props="['title' => 'Shopping Cart', 'breadcrumbs' => $breadcrumbs]">
        <div class="flex items-start gap-4">
            <div class="flex-1" id="cart-page-container">
                <p class="hidden text-3xl font-bold text-gray-300" id="cart-page-loading">Loading...</p>
            </div>
            <!-- Sub total -->
            <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
                <div class="mb-2 flex justify-between">
                    <p class="text-gray-700">Subtotal</p>
                    <p class="text-gray-700">$
                        <span id="sub-total">0.00</span>
                    </p>
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-700">Shipping</p>
                    <p class="text-gray-700">$
                        <span id="shipping">0.00</span>
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
                <button
                    class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Check
                    out</button>
            </div>
        </div>
    </x-page-layout>
</x-app-guest-layout>
<script>
    const cartPageContainer = document.getElementById('cart-page-container');
    const subTotalElement = document.getElementById('sub-total');
    const shippingElement = document.getElementById('shipping');
    const totalElement = document.getElementById('total');


    getCart([renderCartItems, renderSubtotal], 'cart-page-loading')

    function renderCartItems() {
        cartPageContainer.innerHTML = '';
        window.all_cart.forEach(item => {
            const foto = item?.product?.FOTO ? isUserLoggedIn() ?
                'data:image/png;base64,' + JSON.parse(item?.product?.FOTO)[0] : 'data:image/png;base64,' + item
                ?.product
                ?.FOTO :
                'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png'
            const cartItemHtml = `
                    <div class="rounded-lg">
                        <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start border">
                            <img src="${foto}"
                                alt="product-image" class="w-full rounded-lg sm:w-40 border" />
                            <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                <div class="mt-5 sm:mt-0">
                                    <h2 class="text-lg font-bold text-gray-900">${item?.product?.DESCRIZIONEBREVE}</h2>
                                    <p class="mt-1 text-xs ${item?.product?.GIACENZA > 5 ? 'text-green-500':'text-red-500'}">Stock available ${item?.product?.GIACENZA}</p>
                                </div>
                                <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                                    <div class="flex items-center gap-1 border-gray-100">
                                        

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" id="update-quantity-spin-${item.product_id}" class="w-5 h-5 animate-spin mr-3 invisible"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                            <path fill-rule="evenodd"
                                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                        </svg>

                                        <button onclick="cartDecrease(${item?.product_id})"
                                            class="flex items-center justify-center cursor-pointer rounded-l bg-gray-100 h-8 w-10 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                            - </button>
                                        <input id="quantity-input-${item?.product_id}" class="h-8 w-14 text-center"
                                            type="number" value="${item?.quantity}" min="1" />
                                        <button onclick="cartIncrease(${item?.product_id})"
                                            class="flex items-center justify-center cursor-pointer rounded-r bg-gray-100 h-8 w-10 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                            + </button>
                                    </div>
                                    <div class="flex items-center justify-end space-x-4">
                                        <p id="itemPrice" class="text-sm">
                                            ${item?.product?.PRE1IMP ?? 0} $</p>
                                        <button onclick="handleDeleteCart(${item.product_id}, 'cart_page')" class="mb-1">
                                            <x-lucide-trash-2 class="w-5 h-5 text-red-500" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            `;
            cartPageContainer.innerHTML += cartItemHtml;
        });
    }

    function renderSubtotal() {
        const data = window.all_cart;
        const shipping = 30;
        const subtotal = data.reduce((total, item) => {
            const price = item.product.PRE1IMP;
            const quantity = item.quantity;
            if (price) {
                return total + (price * quantity);
            } else {
                return 0;
            }

        }, 0);
        const grandTotal = subtotal + shipping;

        subTotalElement.innerText = subtotal;
        shippingElement.innerText = shipping;
        totalElement.innerText = grandTotal;
    }

    function render() {
        renderCartItems();
        renderSubtotal();
        renderSidebarCart();
        renderSidebarSubtotal();
    }


    function updateQuantity(id, quantity) {
        console.log(`Updating server with quantity ${quantity} for product ${id}`);
        // Simulate server request delay (replace with AJAX call or other server interaction)
        const updateQuantitySpin = document.getElementById('update-quantity-spin-' + id);
        updateQuantitySpin.classList.remove('invisible')
        if (isUserLoggedIn()) {
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
                            const exist_item = window.all_cart.find(item => item.product_id == id);
                            if (exist_item) {
                                exist_item.quantity = quantity;
                            } else {
                                alert('Something went wrong in updateQuantity')
                            }
                        }
                        updateQuantitySpin.classList.add('invisible')
                        render()
                    })
                    .catch(error => {
                        console.log(error);
                        updateQuantitySpin.classList.add('invisible')
                    });
                console.log(`Server updated with quantity ${quantity} for product ${id}`);
            }, 1000);
        } else {
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
                        if (data.success) {
                            const exist_item = window.all_cart.find(item => item.product_id == id);

                            if (exist_item) {
                                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                                let item = cart.find(item => item.product_id === exist_item.product_id);
                                if (item) {
                                    item.quantity = quantity;
                                }
                                localStorage.setItem('cart', JSON.stringify(cart));
                                exist_item.quantity = quantity;
                            } else {
                                alert('Something went wrong in updateQuantity')
                            }
                        }
                        updateQuantitySpin.classList.add('invisible')
                        render()
                    })
                    .catch(error => {
                        updateQuantitySpin.classList.add('invisible')
                        console.log(error);
                    });
                console.log(`Server updated with quantity ${quantity} for product ${id}`);
            }, 1000);
        }
    }

    const debouncedUpdateServer = debounce(updateQuantity, 1000);

    function updateQuantityDisplay(quantity, id) {
        document.getElementById(`quantity-input-${id}`).value = quantity;
    }

    function cartIncrease(id) {
        let quantity = parseInt(document.getElementById(`quantity-input-${id}`).value, 10) || 1;
        quantity++;
        updateQuantityDisplay(quantity, id);
        debouncedUpdateServer(id, quantity);
    }

    function cartDecrease(id) {
        let quantity = parseInt(document.getElementById(`quantity-input-${id}`).value, 10) || 1;
        if (quantity > 1) {
            quantity--;
            updateQuantityDisplay(quantity, id);
            debouncedUpdateServer(id, quantity);
        }
    }

    function debounce(func, delay, id) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }
</script>



{{-- 
@if (isset($cart_items) && !$cart_items->isEmpty())
                    @foreach ($cart_items as $item)
                    @endforeach
                @else
                    <p>No item found</p>
                @endif

--}}
