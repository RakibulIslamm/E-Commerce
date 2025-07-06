@php
    $tenant = tenant();
    // Check if brand_info exists, then if name exists and is not empty
    $brand_title = !empty($tenant->brand_info['name'] ?? null) ? $tenant->brand_info['name'] : 'Ecommerce';
    $favicon = isset($tenant->brand_info['favicon']) ? asset($tenant->brand_info['favicon']) : url('/images/favicon.png');
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- @dd($tenant->brand_info['name']) --}}
    
    <title>@yield('title') | {{ $brand_title ?? config('app.name') }}</title>
    <link rel="icon" href="{{ $favicon }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.bubble.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div id="loading-bar" class="absolute top-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 ease-out" style="width: 0;"></div>
    @if ($user && !$email_verified && $hide_catalogo_mandatory_con_conferma)
        @include('app.components.shared.verify-email')
    @endif
    @include('app.components.shared.navbar.index')
    @include('app.components.shared.cart.cart')
    <main class="w-full h-full">
        {{ $slot }}
    </main>
    @include('app.components.shared.footer.index')
</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  (function() {
    const loadingBar = document.getElementById('loading-bar');

    let timer; // per animazione progressiva

    // Funzione per mostrare la barra e farla crescere fino a ~90%
    function startLoading() {
      clearInterval(timer);
      loadingBar.style.width = '0%';
      loadingBar.style.opacity = '1';

      let width = 0;
      timer = setInterval(() => {
        if (width < 90) {
          width += 1; // aumenta progressivamente
          loadingBar.style.width = width + '%';
        } else {
          clearInterval(timer);
        }
      }, 100); // ogni 100ms aumenta 1%
    }

    // Funzione per completare e nascondere la barra
    function finishLoading() {
      clearInterval(timer);
      loadingBar.style.width = '100%';
      setTimeout(() => {
        loadingBar.style.opacity = '0';
        loadingBar.style.width = '0%';
      }, 300); // lascia il tempo dell'animazione
    }

    // Intercetta i click su link interni (href relativo o stesso dominio)
    document.addEventListener('click', e => {
      const link = e.target.closest('a[href]');
      if (!link) return;

      // Ignora se ha target _blank o link esterno
      const href = link.getAttribute('href');
      if (!href || href.startsWith('http') && !href.startsWith(window.location.origin)) return;
      if (link.target === '_blank') return;

      // Evita link con ancore (#) o mailto
      if (href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('javascript:')) return;

      // Avvia caricamento se link interno
      startLoading();
    });

    // Al caricamento della pagina completa finisce il loading
    window.addEventListener('load', () => {
      finishLoading();
    });
  })();
</script>


<script>
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartSidebarOverlay = document.getElementById('cart-sidebar-overlay');
    const cartContainer = document.getElementById('cart-container');
    const sidebarSubtotal = document.getElementById('sidebar-subtotal');
    const cartCountElements = document.getElementsByClassName('cart-count');
    const cartPageContainer = document.getElementById('cart-page-container');
    const subTotalElement = document.getElementById('sub-total');
    const vatElement = document.getElementById('vat');
    const totalElement = document.getElementById('total');

    const tenant = @json(tenant());

    async function getCart(loadingId = '') {
        window.all_cart = {};
        const loadingElement = document.getElementById(loadingId);
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
        window.all_cart = data.cart_items || {};
        render()
        setCartItemCount();
    }

    getCart();

    function renderSidebarCart() {
        cartContainer.innerHTML = '';
        const items = window.all_cart;
        for (const item in items) {
            const cartInViewQuantityInput = document.getElementById(`cart-in-view-quantity-input-${item}`);
            const cartInViewQuantityInputList = document.getElementById(`list-cart-in-view-quantity-input-${item}`);
            const nColli = document.getElementById(`n-colli-${item}`);
            
            if(cartInViewQuantityInput) {
                cartInViewQuantityInput.value = items[item]?.quantity;
            }

            if(cartInViewQuantityInputList) {
                cartInViewQuantityInputList.value = items[item]?.quantity;
            }

            if(nColli){
                nColli.innerText = `(N. colli: ${items[item]?.quantity / items[item]?.pxc})`
            }


            const cartItem = document.createElement('div');
            const addToCartButtons = document.getElementsByClassName(`add-to-cart-${item}`);

            const plusMinusBtn = document.getElementById(`plus-minus-btn-${item}`);
            const plusMinusBtnList = document.getElementById(`list-plus-minus-btn-${item}`);

            if (addToCartButtons?.length > 0) {
                if(plusMinusBtn){
                    plusMinusBtn.classList.remove('hidden');
                }
                if(plusMinusBtnList){
                    plusMinusBtnList.classList.remove('hidden');
                }
                for (const button of addToCartButtons) {
                    button.setAttribute('disabled', true);
                    button.innerText = 'Aggiungi'
                    button.classList.add('hidden');
                }
            }
            const url = @json(tenant_asset(''))+'/'+items[item]?.photo;
            const FOTO = items[item]?.photo ? url :
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
                            <h3 class="text-sm sm:text-lg line-clamp-1">
                                <a href="/products/details/${item}">${items[item]?.name}</a>
                            </h3>
                            <p class="text-xs sm:text-base">€${ tenant?.price_with_vat ? items[item]?.price_with_vat : items[item]?.price}</p>    
                        </div>
                        <div class="flex sm:items-center sm:flex-row sm:justify-between flex-col items-start mt-3">
                            <div class="flex items-center gap-1 border-gray-100">
                                <button onclick="cartDecreaseSidebar(${item}, ${items[item]?.pxc})"
                                    class="flex items-center justify-center cursor-pointer rounded-l bg-gray-100 h-6 w-8 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                    - </button>
                                <input 
                                class="h-6 w-10 text-center text-xs" id="cart-sidebar-quantity-input-${item}"
                                type="number" 
                                value="${items[item]?.quantity}" 
                                min="1" 
                                onkeydown="if(event.key === 'Enter'){ onBlurCartIncreaseDecreaseInView(${item}, this.value); this.blur(); }"
                                onblur="onBlurCartIncreaseDecreaseInView(${item}, this.value); this.blur()"
                                />
                                <button onclick="cartIncreaseSidebar(${item}, ${items[item]?.pxc})"
                                    class="flex items-center justify-center cursor-pointer rounded-r bg-gray-100 h-6 w-8 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                    + </button>

                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-3 h-3 animate-spin mr-3 invisible update-quantity-spin-${item}"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                    <path fill-rule="evenodd"
                                        d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                </svg>
                            </div>
            
                            <button onclick="handleDeleteCart(${item})" type="button"
                                class="font-medium text-indigo-600 hover:text-indigo-400 text-xs mt-2 sm:text-base sm:mt-0">Rimuovi</button>
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
        const data = Object.values(window.all_cart);
        const subtotal = data.reduce((total, item) => {
            const price = tenant?.price_with_vat ? item.price_with_vat : item.price;
            const quantity = item.quantity;
            if (price) {
                return total + (price * quantity);
            } else {
                return 0;
            }

        }, 0);

        sidebarSubtotal.innerText = subtotal?.toFixed(2);
    }

    function renderCartItems() {
        if (!cartPageContainer) return
        cartPageContainer.innerHTML = '';
        const items = window.all_cart;

        if (!Object?.keys(window?.all_cart)?.length) {
            cartItemHtml = `
            <h2 class="text-2xl font-bold text-gray-400">Cart is empty</h2>
            `;
            cartPageContainer.innerHTML = cartItemHtml;
            return;
        }

        for (const item in items) {
            const url = @json(tenant_asset(''))+'/'+items[item]?.photo;
            const FOTO = items[item]?.photo ? url :
                'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png'
            const cartItemHtml = `
                        <div class="flex items-center gap-3">
                            <img src="${FOTO}"
                                alt="product-image" class="rounded-lg lg:w-[150px] w-[100px] border" />
                            <div class="sm:ml-4 flex w-full justify-between">
                                <div>
                                    <h2 class="sm:text-lg font-bold text-sm text-gray-900 line-clamp-1">${items[item].name}</h2>
                                    <p class="text-xs sm:text-sm ${items[item]?.stock >= 5 ? 'text-green-500' : 'text-red-500'}">Stock disponibile ${items[item]?.stock}</p>
                                    <div class="flex items-center space-x-6">
                                        <p id="itemPrice" class="text-xs sm:text-sm">
                                            ${tenant?.price_with_vat ? items[item]?.price_with_vat : items[item]?.price}€</p>
                                        <button onclick="handleDeleteCart(${item}, 'cart_page')" class="mb-1">
                                            <x-lucide-trash-2 class="sm:w-5 sm:h-5 w-4 h-4 text-red-500" />
                                        </button>
                                    </div>
                                </div>
                                </div>
                                <div class="flex items-center sm:flex-row flex-col gap-1">
                                    <div class="flex items-center gap-1">
                                        <button onclick="cartDecrease(${item}, ${items[item]?.pxc})"
                                        class="flex items-center justify-center cursor-pointer rounded-l bg-gray-100 sm:h-8 sm:w-10 w-5 h-5 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                        - </button>
                                        <input 
                                            class="sm:h-8 sm:w-14 h-5 w-8 text-center sm:text-base text-xs" id="cart-page-quantity-input-${item}"
                                            type="text" 
                                            value="${items[item]?.quantity}"
                                            onkeydown="if(event.key === 'Enter'){ onBlurCartIncreaseDecreaseInView(${item}, this.value); this.blur(); }"
                                            onblur="onBlurCartIncreaseDecreaseInView(${item}, this.value)"
                                        />
                                        <button onclick="cartIncrease(${item}, ${items[item]?.pxc})"
                                            class="flex items-center justify-center cursor-pointer rounded-r bg-gray-100 sm:h-8 sm:w-10 w-5 h-5 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                            + </button>    
                                    </div>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 animate-spin mr-3 invisible update-quantity-spin-${item}"
                                    viewBox="0 0 16 16">
                                        <path
                                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                        <path fill-rule="evenodd"
                                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                    </svg>
                                </div>
                        </div>
                        <hr class="my-2" />
            `;
            cartPageContainer.innerHTML += cartItemHtml;
        }
    }

    function renderSubtotal() {
        if (!subTotalElement || !totalElement) return
        const data = Object.values(window.all_cart);
        let vat = 0;
        const subtotal = data.reduce((total, item) => {
            const price = tenant?.price_with_vat ? item.price_with_vat : item.price;
            const quantity = item?.quantity;
            
            if(!tenant?.price_with_vat){
                vat += (price * quantity) * (parseFloat(item.vat) / 100);
            }

            if (price) {
                return total + (price * quantity);
            } else {
                return 0;
            }

        }, 0);
        const grandTotal = subtotal + vat;
        subTotalElement.innerText = subtotal.toFixed(2);
        if(vatElement) vatElement.innerText = vat.toFixed(2);
        totalElement.innerText = grandTotal.toFixed(2);
    }


    function render() {
        renderCartItems();
        renderSubtotal();
        renderSidebarCart();
        renderSidebarSubtotal();
    }

    function setCartItemCount() {
        const count = Object.keys(window.all_cart).length;
        for (const element of cartCountElements) {
            element.innerText = count > 9 ? "9+" : count;
        }
    }






    const debouncedUpdateServerSidebarCart = debounce(updateQuantitySidebar, 1000);







    // console.log(cartSidebar)
    function openCart() {
        cartSidebar.classList.remove('translate-x-full')
        cartSidebarOverlay.classList.remove('hidden')
        document.body.style.overflow = 'hidden'
    }

    function closeCart() {
        cartSidebar.classList.add('translate-x-full')
        cartSidebarOverlay.classList.add('hidden')
        document.body.style.overflowY = 'auto'
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
                    delete window.all_cart[id];
                    render()
                    setCartItemCount();
                    const addToCartButtons = document.getElementsByClassName(`add-to-cart-${id}`);
                    const plusMinusBtn = document.getElementById(`plus-minus-btn-${id}`);

                    const plusMinusBtnList = document.getElementById(`list-plus-minus-btn-${id}`);

                    if (addToCartButtons?.length > 0) {
                        if(plusMinusBtn){
                            plusMinusBtn.classList.add('hidden');
                        }
                        if(plusMinusBtnList){
                            plusMinusBtnList.classList.add('hidden');
                        }
                        for (const button of addToCartButtons) {
                            button.removeAttribute('disabled', true);
                            button.innerText = 'Aggiungi'
                            button.classList.remove('hidden');
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
