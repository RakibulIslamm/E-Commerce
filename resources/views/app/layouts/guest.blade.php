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

    async function getCart(renderableFunctions, loadingId = '') {
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
            window.all_cart = data.cart_items;

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
                window.all_cart = data.cart_items;
            }
        }
        if (renderableFunctions?.length) {
            for (const func of renderableFunctions) {
                func();
            }
        }
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
            <li class="flex py-6">
                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                    <img src="${FOTO}"
                        alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt."
                        class="h-full w-full object-cover object-center">
                </div>

                <div class="ml-4 flex flex-1 flex-col">
                    <div>
                        <h3>
                            <a href="#">${item?.product?.DESCRIZIONEBREVE}</a>
                        </h3>
                        <p>$${item?.product?.PRE1IMP}</p>
                    </div>
                    <div class="flex flex-1 items-end justify-between text-sm">
                        <p class="text-gray-500">Qty ${item?.quantity}</p>

                        <div class="flex">
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

    function setCartItemCount() {
        const count = window?.all_cart?.length;
        for (const element of cartCountElements) {
            element.innerText = count > 9 ? "9+" : count;
        }
    }


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
                        if (from == 'cart_page') {
                            render();
                        } else {
                            renderSidebarCart();
                            renderSidebarSubtotal();
                        }
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
            if (from == 'cart_page') {
                render();
            } else {
                renderSidebarCart();
                renderSidebarSubtotal();
            }
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

    // Checking user logged in or not
    function isUserLoggedIn() {
        return {{ Auth::check() ? 'true' : 'false' }};
    }
</script>

</html>
