@section('title', 'My Account')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'My account']">
        <x-my-account-layout>

            <div class="p-3">
                <h1 class="text-xl text-gray-400">Welcome <span
                        class="text-2xl text-gray-600 font-semibold">{{ $user->name }}</span>
                </h1>
                <form action="{{ route('app.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="mt-2 px-5 py-1 bg-red-500 text-white rounded-md">
                        Logout
                    </button>
                </form>
            </div>
        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
