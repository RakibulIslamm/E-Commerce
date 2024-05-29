<div
    class="overflow-hidden rounded-r-xl flex items-start h-screen w-[320px] bg-white shadow border-r flex-col justify-between overflow-y-auto scrollbar-none sticky top-0 left-0">
    <div class="w-full">
        <div class="hidden xl:flex justify-start py-5 px-4 items-center space-x-3">
            <x-bx-store-alt class="w-6 h-6 text-gray-700" />
            <a href="/" class="text-xl leading-6 text-gray-700 font-semibold">Ecommerce</a>
        </div>
        <div class="mt-6 flex flex-col justify-start items-center w-full space-y-2 px-4">
            <a href="/dashboard"
                class="flex jusitfy-start items-center space-x-3 w-full rounded hover:text-gray-100 hover:bg-gray-700 {{ Request::is('dashboard*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-bx-store class="w-5 h-5" />
                <p class="text-base leading-4">Dashboard</p>
            </a>
            <a href="#"
                class="flex jusitfy-start items-center space-x-3 w-full rounded hover:text-gray-100 hover:bg-gray-700 {{ Request::is('#') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-bx-user class="w-5 h-5" />
                <p class="text-base leading-4">Customers</p>
            </a>
        </div>
        <div
            class="w-full h-px mt-5 mb-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>
        <div class="flex flex-col justify-start items-center border-gray-600 px-4">
            <button onclick="showMenu1(true)"
                class="focus:outline-none focus:text-gray-900 focus:font-semibold text-left text-gray-700 flex justify-between items-center w-full space-x-14">
                <p class="text-sm leading-5 uppercase">Product</p>
                <x-bx-caret-down id="icon1" class="transform w-6 h-6" />
            </button>
            <div id="menu1" class="flex justify-start flex-col w-full items-start">
                <button
                    class="flex justify-start items-center gap-2 hover:text-gray-100 focus:bg-gray-700 focus:text-gray-100 hover:bg-gray-700 text-gray-400 rounded px-3 py-2 w-full my-2">
                    <x-bx-list-ul class="w-6 h-6" />
                    <p class="text-base leading-4">Porduct list</p>
                </button>
            </div>
        </div>
        <div
            class="block h-px mb-5 mt-2 bg-transparent bg-gradient-to-r from-transparent via-gray-500/40 to-transparent">
        </div>
        <div class="px-4">
            <a href="/settings" {{-- {{ route('app.settings') }} --}}
                class="flex jusitfy-start items-center space-x-3 hover:text-gray-100 hover:bg-gray-700 {{ Request::is('settings*') ? 'bg-gray-700 text-gray-100' : 'text-gray-700' }} rounded px-3 py-2 w-full">
                <x-lucide-settings class="w-5 h-5" />
                <p class="text-base leading-4">Settings</p>
            </a>
        </div>
    </div>

    <div class="flex justify-between items-center w-full p-6">
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
    let menu1 = document.getElementById("menu1");
    const showMenu1 = (flag) => {
        if (flag) {
            icon1.classList.toggle("rotate-180");
            menu1.classList.toggle("hidden");
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
