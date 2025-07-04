<div id="cart-sidebar-overlay" onclick="closeCart()"
    class="hidden fixed top-0 left-0 w-full h-screen bg-black bg-opacity-40 backdrop-blur-sm z-[50]">
</div>
<div id="cart-sidebar"
    class="sm:w-[400px] w-[85%] h-screen transform translate-x-full  fixed top-0 right-0 z-[60] bg-slate-50 transition-all ease-in-out duration-300 flex flex-col justify-between">

    <div class="flex items-start justify-between p-3">
        <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Carrello</h2>
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
            <p>Subtotale</p>
            <p>€
                <span id="sidebar-subtotal">0.00</span>
            </p>
        </div>
        <div class="mt-6">
            <a href="/cart"
                class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Vai al carrello</a>
        </div>
    </div>
</div>

<script>
    function updateQuantitySidebar(id, quantity) {
        console.log(`Updating server with quantity ${quantity} for product ${id}`);
        // Simulate server request delay (replace with AJAX call or other server interaction)
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
                    if (data.success) {
                        window.all_cart = data.cart_items;
                        render()
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                    render()
                    quantitySpinUpdate(id, 'invisible');
                })
                .catch(error => {
                    console.log(error);
                    quantitySpinUpdate(id, 'invisible');
                })
                .finally(()=>{
                    quantitySpinUpdate(id, 'invisible');
                })
            quantitySpinUpdate(id, 'invisible');
            console.log(`Server updated with quantity ${quantity} for product ${id}`);
        }, 1000);
    }

    function updateQuantityDisplaySidebar(quantity, id) {
        document.getElementById(`cart-sidebar-quantity-input-${id}`).value = quantity;
        
        if(document.getElementById(`cart-in-view-quantity-input-${id}`)){
            document.getElementById(`cart-in-view-quantity-input-${id}`).value = quantity;
        }
        if(document.getElementById(`list-cart-in-view-quantity-input-${id}`)){
            document.getElementById(`list-cart-in-view-quantity-input-${id}`).value = quantity;
        }
    }

    function cartIncreaseSidebar(id, pxc=1) {
        let quantity = parseInt(document.getElementById(`cart-sidebar-quantity-input-${id}`).value, 10) ||
            1;
        quantity+=pxc;

        updateQuantityDisplaySidebar(quantity, id);
        debouncedUpdateServerSidebarCart(id, quantity);
    }

    function cartDecreaseSidebar(id, pxc=1) {
        let quantity = parseInt(document.getElementById(`cart-sidebar-quantity-input-${id}`).value, 10) ||
            1;
        if (quantity > 1) {
            quantity -= pxc;
            updateQuantityDisplaySidebar(quantity, id);
            debouncedUpdateServerSidebarCart(id, quantity);
        }
    }



    function cartIncreaseInView(id, pxc=1) {
        let quantity = parseInt(document.getElementById(`cart-in-view-quantity-input-${id}`).value, 10) ||
            1;
        quantity+=pxc;
        updateQuantityDisplaySidebar(quantity, id);
        debouncedUpdateServerSidebarCart(id, quantity);
    }
    
    function onBlurCartIncreaseDecreaseInView(id, quantity) {
        updateQuantityDisplaySidebar(quantity, id);
        debouncedUpdateServerSidebarCart(id, quantity);
    }

    function cartDecreaseInView(id, pxc=1) {
        let quantity = parseInt(document.getElementById(`cart-in-view-quantity-input-${id}`).value, 10) ||
            1;
        if (quantity > 1) {
            quantity -= pxc;
            updateQuantityDisplaySidebar(quantity, id);
            debouncedUpdateServerSidebarCart(id, quantity);
        }
    }
</script>
