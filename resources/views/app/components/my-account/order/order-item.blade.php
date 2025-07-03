<div class="flex flex-col md:flex-row items-center justify-between {{$loop->last ? '' : 'border-b'}} pb-4">
    <div>
        <p class="text-gray-600">ID Ordine: <span class="font-medium text-gray-800">#{{$order->id}}</span></p>
        <p class="text-gray-600">Data: 
            <span class="font-medium text-gray-800">
                {{ \Carbon\Carbon::parse($order->created_at)->setTimezone('Europe/Rome')->locale('it')->translatedFormat('j F Y, H:i') }}
            </span>
        </p>
        
        @php
            $total = $order->totale_netto + $order->spese_spedizione + $order->cod_fee + $order->totale_iva;
        @endphp

        <p class="text-gray-600">Totale (Includendo le spese): <span class="font-medium text-gray-800">{{ number_format($total, 2) }}€</span></p>

        <!-- Stato dell'ordine -->
        <p class="mt-2">
            <span class="text-sm font-medium text-gray-800">Stato:</span>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium border">
                @if ($order->stato == -1)
                    <span>In attesa</span>
                @elseif($order->stato == 0)
                    <span>Accettato</span>
                @elseif($order->stato == 1)
                    <span>In preparazione</span>
                @elseif($order->stato == 2)
                    <span>Spedito</span>
                @endif
            </span>

            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium ml-3 border">
                {{$order->pagato == 0 ? 'Non pagato' : 'Pagato'}}
            </span>
        </p>
    </div>

    <div class="mt-4 md:mt-0">
        <a href="{{ route('app.account.orders.show', $order) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Visualizza Dettagli
        </a>
    </div>
</div>
