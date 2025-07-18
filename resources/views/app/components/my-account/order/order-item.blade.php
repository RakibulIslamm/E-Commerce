<div class="flex flex-col md:flex-row justify-between md:items-center {{ $loop->last ? '' : 'border-b' }} pb-4 gap-4">
    <!-- Left (Order Info) -->
    <div class="">
        <p class="text-gray-600 text-sm">
            ID Ordine:
            <span class="font-medium text-gray-800">#{{ $order->id }}</span>
        </p>
        <p class="text-gray-600 text-sm">
            Data:
            <span class="font-medium text-gray-800">
                {{ \Carbon\Carbon::parse($order->created_at)->setTimezone('Europe/Rome')->locale('it')->translatedFormat('j F Y, H:i') }}
            </span>
        </p>

        @php
            $total = $order->totale_netto + $order->spese_spedizione + $order->cod_fee + $order->totale_iva;
        @endphp

        <p class="text-gray-600 text-sm">
            Totale (Includendo le spese):
            <span class="font-medium text-gray-800">{{ number_format($total, 2) }}€</span>
        </p>

        <!-- Stato -->
        <div class="mt-2 flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium border">
                @if ($order->stato == -1)
                    In attesa
                @elseif ($order->stato == 0)
                    Accettato
                @elseif ($order->stato == 1)
                    In preparazione
                @elseif ($order->stato == 2)
                    Spedito
                @endif
            </span>

            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium border">
                {{ $order->pagato == 0 ? 'Non pagato' : 'Pagato' }}
            </span>
        </div>
    </div>

    <!-- Right (CTA) -->
    <div class="md:text-right">
        <a href="{{ route('app.account.orders.show', $order) }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition w-full md:w-auto text-center">
            Visualizza Dettagli
        </a>
    </div>
</div>
