@section('title', "Dettagli dell'ordine")

<x-app-guest-layout>
  <x-page-layout :props="['title' => 'Dettagli dell\'ordine']">
    <x-my-account-layout>
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-md border p-4 sm:p-6">
          <h1 class="text-xl font-bold text-gray-800">Ordine ID: #{{ $order->id ?? 'N/A' }}</h1>

          <div class="mt-2 space-y-1 text-gray-600">
            <p>Data dell'ordine:
              <span class="font-medium text-gray-800">
                {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->setTimezone('Europe/Rome')->locale('it')->translatedFormat('j F Y, H:i') : 'N/A' }}
              </span>
            </p>
            <p>Spese di spedizione: <span class="font-medium text-gray-800">{{ $order->spese_spedizione ?? '0' }}€</span></p>
            <p>Spese per pagamento in contrassegno: <span class="font-medium text-gray-800">{{ $order->cod_fee ?? '0' }}€</span></p>
            <p>IVA: <span class="font-medium text-gray-800">{{ $order->totale_iva ?? '0' }}€</span></p>

            @php
              $total = ($order->totale_netto ?? 0) + ($order->spese_spedizione ?? 0) + ($order->cod_fee ?? 0) + ($order->totale_iva ?? 0);
            @endphp
            <p>Totale (incl. tasse): <span class="font-medium text-gray-800">{{ number_format($total, 2) }}€</span></p>
          </div>

          <!-- Status -->
          <div class="mt-4 flex flex-wrap items-center gap-2">
            <span class="text-sm font-medium text-gray-800">Stato:</span>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium border">
              @switch($order->stato)
                @case(-1) In attesa @break
                @case(0) Preso @break
                @case(1) Preparazione @break
                @case(2) Spedito @break
                @default Non definito
              @endswitch
            </span>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium border">
              {{ $order->pagato == 0 ? 'Non pagato' : 'Pagato' }}
            </span>
          </div>
        </div>

        <!-- Items -->
        <div class="bg-white rounded-lg shadow-md border mt-6 p-4 sm:p-6">
          <h2 class="text-lg font-semibold text-gray-800">Articoli nel tuo ordine</h2>
          <div class="mt-4 space-y-4">
            @foreach ($order->articoli ?? [] as $item)
              @php
                $FOTO = "https://via.placeholder.com/80";
                if (isset($item->product->FOTO)) {
                    $decoded = json_decode($item->product->FOTO);
                    if (!empty($decoded[0])) {
                        $FOTO = tenant_asset($decoded[0]);
                    }
                }
              @endphp
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img src="{{ $FOTO }}" alt="Immagine del prodotto" class="w-20 h-20 object-cover rounded-md shadow">
                <div class="flex-1">
                  <h3 class="text-gray-800 font-medium">{{ $item->product->DESCRIZIONEBREVE ?? 'Descrizione non disponibile' }}</h3>
                  <p class="text-sm text-gray-600">Quantità: {{ $item->qta ?? '0' }}</p>
                </div>
                <p class="text-gray-800 font-medium whitespace-nowrap">{{ $item->imponibile ?? '0' }}€</p>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-md border mt-6 p-4 sm:p-6">
          <h2 class="text-lg font-semibold text-gray-800">Indirizzo di spedizione</h2>
          <div class="mt-2 text-gray-600 space-y-1">
            <p>{{ $order->nominativo_spedizione ?? 'Non disponibile' }}</p>
            <p>{{ $order->indirizzo_spedizione ?? 'Non disponibile' }}</p>
            <p>{{ $order->citta_spedizione ?? 'Non disponibile' }}, {{ $order->shipping_state ?? '' }} {{ $order->cap_spedizione ?? '' }}</p>
            <p>{{ $order->provincia_spedizione ?? '' }}</p>

            <p class="mt-2"><strong>Telefono:</strong> {{ $order->telefono ?? 'Non disponibile' }}</p>
            <p><strong>Email:</strong> {{ $order->email ?? 'Non disponibile' }}</p>
          </div>
        </div>

      </div>
    </x-my-account-layout>
  </x-page-layout>
</x-app-guest-layout>
