@section('title', 'My Orders')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'I miei ordini']">
        <x-my-account-layout>
            <div class="space-y-5">
                @if (!$orders->isEmpty())
                    @foreach ($orders as $order)
                        @include('app.components.my-account.order.order-item', [
                            'order_items' => $order->order_items,
                        ])
                    @endforeach
                @else
                    <h2>No order found</h2>
                @endif
            </div>
        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
{{-- @dd($orders) --}}
