@section('title', 'Il mio account')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Il mio account']">
        <x-my-account-layout>

            <div class="p-3">
                <h1 class="text-xl text-gray-400">Benvenuto <span
                        class="text-2xl text-gray-600 font-semibold">{{ $user->name ?? 'Utente sconosciuto' }}</span>
                </h1>
                <form action="{{ route('app.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="mt-2 px-5 py-1 bg-red-500 text-white rounded-md">
                        Esci
                    </button>
                </form>
            </div>
        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
