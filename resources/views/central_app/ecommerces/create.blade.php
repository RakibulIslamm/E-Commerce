@section('title', 'Create ecommerce')

<x-central-app-layout>

    <div class="w-full p-6">
        <h2 class="py-3 text-xl font-bold">
            @if ($mode == 'create')
                Create Ecommerce
            @elseif($mode == 'edit')
                Edit Ecommerce
            @endif
        </h2>
        @if (session()->has('error'))
            <div class="px-10 py-2 bg-red-400 text-red-800 font-semibold flex items-center justify-between"
                id="session_status">
                <p>{{ session('error') }}</p>
                <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
            </div>
        @endif
        @include('central_app.ecommerces.partials.form')
    </div>

</x-central-app-layout>
