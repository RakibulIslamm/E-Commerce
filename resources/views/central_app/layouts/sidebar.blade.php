<aside class="w-[350px] shadow h-screen bg-white sticky top-0 left-0">
    <div class="flex flex-col justify-between h-full">
        <div>
            <div class="px-4 flex items-center justify-start border-b h-[60px]">
                <h1 class="text-xl font-bold">Aster</h1>
            </div>
            <div class="p-3 space-y-1">
                <a href="/dashboard"
                    class="{{ Request::is('dashboard') ? 'bg-gray-200 rounded-md font-semibold' : '' }} px-3 py-2 flex items-center">
                    <span>Home</span>
                </a>
                @if (in_array($user->role, [1, 2, 3]))
                    <a href="/ecommerces"
                        class="{{ Request::is('ecommerces*') ? 'bg-gray-200 rounded-md font-semibold' : '' }} px-3 py-2 flex items-center">
                        <span>Ecommerces</span>
                    </a>
                @endif
                @if (in_array($user->role, [1, 3, 5]))
                    <a href="/ecommerce/requests"
                        class="{{ Request::is('ecommerce/requests*') ? 'bg-gray-200 rounded-md font-semibold' : '' }} px-3 py-2 flex items-center">
                        <span>{{ $user->role == 1 || $user->role == 3 ? 'Ecommerces Requests' : 'My Request' }}</span>
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}"
                    class="{{ Request::is('profile') ? 'bg-gray-200 rounded-md font-semibold' : '' }} px-3 py-2 flex items-center">
                    <span>Edit profile</span>
                </a>

                {{-- Add more conditions similarly for other links --}}
            </div>
        </div>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"
                class="w-full inline-flex items-center justify-center h-9 px-4 bg-gray-900 text-gray-300 hover:text-white text-sm font-semibold transition">
                <span class="font-bold text-sm">Logout</span>
            </button>
        </form>
    </div>
</aside>
