<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.bubble.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    {{-- @include('app.components.shared.top-bar.index') --}}
    @include('app.components.shared.navbar.index')
    @include('app.components.shared.cart.cart')
    <main>
        {{ $slot }}
    </main>
    @include('app.components.shared.footer.index')
</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartContainer = document.getElementById('cart-container');
    const sidebarSubtotal = document.getElementById('sidebar-subtotal');
    const cartCountElements = document.getElementsByClassName('cart-count');
    const cartPageContainer = document.getElementById('cart-page-container');
    const subTotalElement = document.getElementById('sub-total');
    const shippingElement = document.getElementById('shipping');
    const totalElement = document.getElementById('total');

    async function getCart(loadingId = '') {
        window.all_cart = [];
        const loadingElement = document.getElementById(loadingId);
        if (isUserLoggedIn()) {
            loadingElement && loadingElement.classList.remove('hidden')
            const res = await fetch('/get-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await res.json();
            loadingElement && loadingElement.classList.remove('hidden')
            window.all_cart = data.cart_items || [];

        } else {
            const cartData = localStorage.getItem('cart');
            if (cartData) {
                loadingElement && loadingElement.classList.remove('hidden')
                const res = await fetch('/get-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart: cartData
                    })
                });
                const data = await res.json();
                loadingElement && loadingElement.classList.remove('hidden')
                window.all_cart = data.cart_items
            }
        }
        render()
        setCartItemCount();
    }

    getCart([renderSidebarCart, renderSidebarSubtotal]);

    function renderSidebarCart() {
        cartContainer.innerHTML = '';
        for (const item of window.all_cart) {

            const cartItem = document.createElement('div');
            const addToCartButtons = document.getElementsByClassName(`add-to-cart-${item.product.id}`);

            if (addToCartButtons?.length > 0) {
                for (const button of addToCartButtons) {
                    button.setAttribute('disabled', true);
                    button.innerText = 'Added'
                }
            }

            const FOTO = item?.product?.FOTO ? isUserLoggedIn() ?
                'data:image/png;base64,' + JSON.parse(item?.product?.FOTO)[0] :
                'data:image/png;base64,' + item?.product
                ?.FOTO :
                'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png'

            cartItem.innerHTML = `
            <li class="py-6">
                <div class="flex items-start gap-3">
                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                    <img src="${FOTO}"
                        alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt."
                        class="h-full w-full object-cover object-center">
                    </div>
                    <div class="w-full">
                        <div>
                            <h3>
                                <a href="#">${item?.product?.DESCRIZIONEBREVE}</a>
                            </h3>
                            <p>$${item?.product?.PRE1IMP}</p>    
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-1 border-gray-100">
                                <button onclick="cartDecreaseSidebar(${item?.product_id})"
                                    class="flex items-center justify-center cursor-pointer rounded-l bg-gray-100 h-4 w-6 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                    - </button>
                                <input class="h-4 w-10 text-center text-xs" id="cart-sidebar-quantity-input-${item?.product_id}"
                                    type="number" value="${item?.quantity}" min="1" />
                                <button onclick="cartIncreaseSidebar(${item?.product_id})"
                                    class="flex items-center justify-center cursor-pointer rounded-r bg-gray-100 h-4 w-6 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                    + </button>

                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-3 h-3 animate-spin mr-3 invisible update-quantity-spin-${item.product_id}"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                    <path fill-rule="evenodd"
                                        d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                </svg>
                            </div>
            
                            <button onclick="handleDeleteCart(${item?.product_id})" type="button"
                                class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                        </div>
                    </div>    
                </div>
            </li>
            `

            cartContainer.appendChild(cartItem.firstElementChild);
        }
    }
    // <p class="text-gray-500">Qty ${item?.quantity}</p>
    function renderSidebarSubtotal() {
        const data = window.all_cart;
        const subtotal = data.reduce((total, item) => {
            const price = item.product.PRE1IMP;
            const quantity = item.quantity;
            if (price) {
                return total + (price * quantity);
            } else {
                return 0;
            }

        }, 0);

        sidebarSubtotal.innerText = subtotal;
    }

    function renderCartItems() {
        if (!cartPageContainer) return
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
                                        

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 animate-spin mr-3 invisible update-quantity-spin-${item.product_id}"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                            <path fill-rule="evenodd"
                                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                        </svg>

                                        <button onclick="cartDecrease(${item?.product_id})"
                                            class="flex items-center justify-center cursor-pointer rounded-l bg-gray-100 h-8 w-10 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                            - </button>
                                        <input class="h-8 w-14 text-center" id="cart-page-quantity-input-${item?.product_id}"
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
        if (!subTotalElement || !shippingElement || !totalElement) return
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

    function setCartItemCount() {
        const count = window?.all_cart?.length;
        for (const element of cartCountElements) {
            element.innerText = count > 9 ? "9+" : count;
        }
    }






    const debouncedUpdateServerSidebarCart = debounce(updateQuantitySidebar, 1000);







    // console.log(cartSidebar)
    function openCart() {
        cartSidebar.classList.remove('translate-x-full')
    }

    function closeCart() {
        cartSidebar.classList.add('translate-x-full')
    }

    // Set local storage cart to database
    if (localStorage.getItem('cart') && isUserLoggedIn()) {
        fetch('/set-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: localStorage.getItem('cart')
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('cart');
                }
            });
    }

    // Delete cart
    function handleDeleteCart(id, from = 'sidebar') {
        if (isUserLoggedIn()) {
            fetch('/cart/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    if (data.success) {
                        window.all_cart = window?.all_cart?.filter(item => item.product_id != id);
                        render()
                        setCartItemCount();
                        const addToCartButtons = document.getElementsByClassName(`add-to-cart-${id}`);

                        if (addToCartButtons?.length > 0) {
                            for (const button of addToCartButtons) {
                                button.removeAttribute('disabled', true);
                                button.innerText = 'Add'
                            }
                        }
                    } else {
                        console.error('Failed to delete item');
                    }
                })
                .catch(error => {
                    // Handle fetch errors or JSON parsing errors
                    console.error('Fetch error:', error);
                });
        } else {
            const cartItems = JSON.parse(localStorage.getItem('cart'));
            const filteredCart = cartItems?.filter(item => item?.product_id != id);
            localStorage.setItem('cart', JSON.stringify(filteredCart));
            window.all_cart = filteredCart;
            render();
            setCartItemCount();
            const addToCartButtons = document.getElementsByClassName(`add-to-cart-${id}`);

            if (addToCartButtons?.length > 0) {
                for (const button of addToCartButtons) {
                    button.removeAttribute('disabled', true);
                    button.innerText = 'Add'
                }
            }
        }
    }

    // Cart updating spin
    function quantitySpinUpdate(id, status) {
        const quantitySpinElement = document.getElementsByClassName('update-quantity-spin-' + id);
        if (quantitySpinElement) {
            for (const elem of quantitySpinElement) {
                elem.classList.toggle(status)
            }
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

    // Checking user logged in or not
    function isUserLoggedIn() {
        return {{ Auth::check() ? 'true' : 'false' }};
    }
</script>

</html>
