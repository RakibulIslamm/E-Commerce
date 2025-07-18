<div
    class="overflow-hidden rounded-r-xl flex items-start h-screen w-[320px] bg-white shadow border-r flex-col justify-between overflow-y-auto scrollbar-none sticky top-0 left-0">
    <div class="w-full">
        <a href="/" class="flex justify-start py-5 px-4 items-center space-x-3 sticky top-0 bg-white">
            <x-bx-store-alt class="w-6 h-6 text-gray-700" />
            <span
                class="text-xl leading-6 text-gray-700 font-semibold">{{ !empty($tenant->brand_info['name'] ?? null) ? $tenant->brand_info['name'] : 'Ecommerce' }}</span>
        </a>
        <div class="mt-6 flex flex-col justify-start items-center w-full space-y-2 px-2">
            <a href="/dashboard"
                class="flex jusitfy-start items-center space-x-3 w-full rounded hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-bx-store class="w-5 h-5" />
                <p class="text-base leading-4">Dashboard</p>
            </a>
            <a href="{{ route('app.dashboard.slider') }}"
                class="flex jusitfy-start items-center space-x-3 w-full rounded hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard/slider*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-bx-slideshow class="w-5 h-5" />
                <p class="text-base leading-4">Slider</p>
            </a>
            <a href="{{ route('app.dashboard.news') }}"
                class="flex jusitfy-start items-center space-x-3 w-full rounded hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard/news*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-bx-news class="w-5 h-5" />
                <p class="text-base leading-4">Articoli</p>
            </a>
            <a href="{{ route('app.dashboard.customers') }}"
                class="flex jusitfy-start items-center space-x-3 w-full rounded hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard/customers') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-bx-user class="w-5 h-5" />
                <span class="text-base leading-4">Clienti</span>
            </a>

        </div>
        <div
            class="w-full h-px mt-5 mb-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>
        <div class="flex flex-col items-start border-gray-600 px-4">
            <button onclick="showMenu1(true)"
                class="focus:outline-none focus:text-gray-900 focus:font-semibold text-left text-gray-700 flex justify-between items-center w-full space-x-14">
                <p class="text-sm leading-5 uppercase">Prodotti</p>
                <x-bx-caret-down id="icon1"
                    class="transform w-3 h-3 {{ Request::is('products*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="menu1" class="{{ Request::is('dashboard/products*') ? 'block' : 'hidden' }} w-full">
                <a href="{{ route('app.dashboard.products') }}"
                    class="flex justify-start items-center gap-2 hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard/products') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full my-2">
                    <x-bx-list-ul class="w-5 h-5" />
                    <p class="text-sm leading-4">Lista prodotti</p>
                </a>
                <a href="{{ route('app.dashboard.categories') }}"
                    class="flex justify-start items-center gap-2 hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard/products/categories') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full my-2">
                    <x-bx-list-ul class="w-5 h-5" />
                    <p class="text-sm leading-4">Categorie</p>
                </a>
            </div>
        </div>
        <div
            class="block h-px mb-5 mt-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>


        <div
            class="w-full h-px mt-5 mb-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>
        <div class="flex flex-col items-start border-gray-600 px-4">
            <button onclick="showMenu2(true)"
                class="focus:outline-none focus:text-gray-900 focus:font-semibold text-left text-gray-700 flex justify-between items-center w-full space-x-14">
                <p class="leading-5 uppercase">Contenuti azienda</p>
                <x-bx-caret-down id="icon2"
                    class="transform w-3 h-3 {{ Request::is('dashboard/corporate-content*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="menu2" class="{{ Request::is('dashboard/corporate-content*') ? 'block' : 'hidden' }} w-full">
                <a href="{{ route('app.corporate-data') }}"
                    class="flex justify-start items-center gap-2 {{ Request::is('dashboard/corporate-content/corporate-data*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 hover:text-gray-100 rounded px-3 py-2 w-full my-2">
                    <x-lucide-settings class="w-5 h-5" />
                    <p class="text-sm leading-4">Dati Azienda</p>
                </a>
                <a style="display:none" href="{{ route('app.corporate-content.ecommerce') }}"
                    class="flex justify-start items-center gap-2 hover:text-gray-100 {{ Request::is('dashboard/corporate-content/ecommerce*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 rounded px-3 py-2 w-full my-2">
                    <x-lucide-settings-2 class="w-5 h-5" />
                    <p class="text-sm leading-4">Ecommerce</p>
                </a>
                <a href="{{ route('app.corporate-content.company-profile') }}"
                    class="flex justify-start items-center gap-2 hover:text-gray-100 {{ Request::is('dashboard/corporate-content/company-profile*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 rounded px-3 py-2 w-full my-2">
                    <x-lucide-info class="w-5 h-5" />
                    <p class="text-sm leading-4">Profilo Azienda</p>
                </a>
                <a href="{{ route('app.corporate-content.condition-for-sale') }}"
                    class="flex justify-start items-center gap-2 hover:text-gray-100 {{ Request::is('dashboard/corporate-content/condition-for-sale*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 rounded px-3 py-2 w-full my-2">
                    <x-heroicon-o-document-text class="w-5 h-5" />
                    <p class="text-sm leading-4">Condizioni di vendita</p>
                </a>
                
                <a href="{{ route('app.corporate-content.privacy-and-cookie') }}"
                    class="flex justify-start items-center gap-2 hover:text-gray-100 {{ Request::is('dashboard/corporate-content/privacy-and-cookie*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 rounded px-3 py-2 w-full my-2">
                    <x-heroicon-o-document-text class="w-5 h-5" />
                    <p class="text-sm leading-4">Privacy And Cookie</p>
                </a>
            </div>
        </div>
        <div
            class="block h-px mb-5 mt-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>

        <div
            class="w-full h-px mt-5 mb-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>
        <div class="flex flex-col items-start border-gray-600 px-4">
            <button onclick="showMenu3(true)"
                class="focus:outline-none focus:text-gray-900 focus:font-semibold text-left text-gray-700 flex justify-between items-center w-full space-x-14">
                <p class="leading-5 uppercase">Opzioni</p>
                <x-bx-caret-down id="icon3"
                    class="transform w-3 h-3 {{ Request::is('corporate-content*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="menu3" class="{{ Request::is('dashboard/options*') ? 'block' : 'hidden' }} w-full">
                <a href="{{ route('app.change-password') }}"
                    class="flex justify-start items-center gap-2 {{ Request::is('dashboard/options/change-password') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 hover:text-gray-100 rounded px-3 py-2 w-full my-2">
                    <x-lucide-lock-keyhole class="w-5 h-5" />
                    <p class="text-sm leading-4">Cambiare la password</p>
                </a>

                <a href="{{ route('app.shipping-settings') }}"
                    class="flex justify-start items-center gap-2 {{ Request::is('dashboard/options/shipping-settings') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 hover:text-gray-100 rounded px-3 py-2 w-full my-2">
                    <x-lucide-map-pinned class="w-5 h-5" />
                    <p class="text-sm leading-4">Dati di spedizione</p>
                </a>

                <a href="{{ route('app.cap') }}"
                    class="flex justify-start items-center gap-2 {{ Request::is('dashboard/options/cap') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 hover:text-gray-100 rounded px-3 py-2 w-full my-2">
                    <x-lucide-map-pin-off class="w-5 h-5" />
                    <p class="text-sm leading-4">Limitazioni per il CAP</p>
                </a>

                <a href="#"
                    class="flex justify-start items-center gap-2 {{ Request::is('dashboard/options/discount') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 hover:text-gray-100 rounded px-3 py-2 w-full my-2">
                    <x-lucide-ticket-percent class="w-5 h-5" />
                    <p class="text-sm leading-4">Gestione degli sconti</p>
                </a>

                <a href="{{ route('app.promotions') }}"
                    class="flex justify-start items-center gap-2 {{ Request::is('dashboard/options/promotions') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} hover:bg-gray-700 hover:text-gray-100 rounded px-3 py-2 w-full my-2">
                    <x-hugeicons-promotion class="w-5 h-5" />
                    <p class="text-sm leading-4">Promozioni</p>
                </a>
            </div>
        </div>
        <div
            class="block h-px mb-5 mt-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>
    </div>

    <div class="flex justify-between items-center w-full p-6 sticky bottom-0 bg-white">
        <div class="flex justify-center items-center space-x-2">
            <div>
                <img class="rounded-full" src="https://i.ibb.co/L1LQtBm/Ellipse-1.png" alt="avatar" />
            </div>
            <div class="flex justify-start flex-col items-start">
                <p class="cursor-pointer text-sm leading-5 text-gray-900">
                    {{ $user->name }}
                </p>
                <p class="cursor-pointer text-xs leading-3 text-gray-700">
                    {{ $user->email }}
                </p>
            </div>
        </div>
        <form action="{{ route('app.logout') }}" method="post">
            @csrf
            <button type="submit">
                <x-bx-exit class="w-6 h-6 text-gray-700" />
            </button>
        </form>
    </div>
</div>

<script>
    let icon1 = document.getElementById("icon1");
    let icon2 = document.getElementById("icon2");
    let icon3 = document.getElementById("icon3");
    let menu1 = document.getElementById("menu1");
    let menu2 = document.getElementById("menu2");
    let menu3 = document.getElementById("menu3");
    const showMenu1 = (flag) => {
        if (flag) {
            icon1.classList.toggle("rotate-180");
            menu1.classList.toggle("hidden");
        }
    };
    const showMenu2 = (flag) => {
        if (flag) {
            icon2.classList.toggle("rotate-180");
            menu2.classList.toggle("hidden");
        }
    };
    const showMenu3 = (flag) => {
        if (flag) {
            icon3.classList.toggle("rotate-180");
            menu3.classList.toggle("hidden");
        }
    };

    let Main = document.getElementById("Main");
    let open = document.getElementById("open");
    let close = document.getElementById("close");

    const showNav = (flag) => {
        if (flag) {
            Main.classList.toggle("-translate-x-full");
            Main.classList.toggle("translate-x-0");
            open.classList.toggle("hidden");
            close.classList.toggle("hidden");
        }
    };
</script>
