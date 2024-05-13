@section('title', 'Create ecommerce')

<x-app-layout>

    <div class="w-full p-6">
        <h2 class="py-3 text-xl font-bold">
            @if($mode == 'create')
                Create Ecommerce
            @elseif($mode == 'edit')
                Edit Ecommerce
            @endif
        </h2>
        @include('ecommerces.partials.form')
    </div>

</x-app-layout>

