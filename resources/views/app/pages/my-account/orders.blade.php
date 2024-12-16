@section('title', 'I miei ordini')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'I miei ordini']">
        <x-my-account-layout>
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                {{-- <h1 class="text-2xl font-bold text-gray-800">I miei ordini</h1>
                <p class="text-gray-600 mt-2">Visualizza e gestisci i tuoi ordini recenti.</p>
                --}}
                <!-- Order List -->
                <div class="bg-white rounded-lg shadow-md mt-2">
                  <h2 class="text-lg font-semibold text-gray-800">Storico ordini</h2>
                  <div class="mt-4 space-y-6">
                    @if (!$orders->isEmpty())
                        @foreach ($orders as $order)
                            @include('app.components.my-account.order.order-item', [
                                'order_items' => $order->order_items ?? []
                            ])
                        @endforeach
                    @else
                        <h2 class="text-center text-gray-600">Nessun ordine trovato</h2>
                    @endif
                  </div>
                </div>
              </div>
        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
{{-- @dd($orders) --}}
