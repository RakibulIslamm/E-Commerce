@section('title', 'My Orders')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'My orders']">
        <x-my-account-layout>
            <p>Order found: {{ count($orders) }}</p>

        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
@dd($orders)
