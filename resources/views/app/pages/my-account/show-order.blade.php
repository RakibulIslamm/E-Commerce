@section('title', "Dettagli dell'ordine")
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Dettagli dell\'ordine']">
        <x-my-account-layout>
          <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-md border p-6">
              <h1 class="text-xl font-bold text-gray-800">Ordine ID: #{{$order->id ?? 'N/A'}}</h1>
              
              <p class="text-gray-600">Data dell'ordine: 
                  <span class="font-medium text-gray-800">
                      {{ $order->created_at ? $order->created_at->locale('it')->translatedFormat('j F Y, H:i') : 'N/A' }}
                  </span>
              </p>

              <p class="text-gray-600">Spese di spedizione: <span class="font-medium text-gray-800">{{ $order->spese_spedizione ?? '0' }}€</span></p>

              <p class="text-gray-600">Spese per pagamento in contrassegno: <span class="font-medium text-gray-800">{{ $order->cod_fee ?? '0' }}€</span></p>

              <p class="text-gray-600">IVA: <span class="font-medium text-gray-800">{{ $order->totale_iva ?? '0' }}€</span></p>
              @php
                  $total = ($order->totale_netto ?? 0) + ($order->spese_spedizione ?? 0) + ($order->cod_fee ?? 0) + ($order->totale_iva ?? 0);
              @endphp
              <p class="text-gray-600">Totale (incl. tasse): <span class="font-medium text-gray-800">{{ number_format($total, 2) }}€</span></p>
              <!-- Status -->
              <p class="mt-4">
                <span class="text-sm font-medium text-gray-800">Stato:</span>
                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium border">
                    @if ($order->stato == -1)
                        <span>In attesa</span>
                    @elseif($order->stato == 0)
                        <span>Preso</span>
                    @elseif($order->stato == 1)
                        <span>Preparazione</span>
                    @elseif($order->stato == 2)
                        <span>Spedito</span>
                    @else
                        <span>Non definito</span>
                    @endif
                </span>
                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium ml-3 border">
                    {{$order->pagato == 0 ? 'Non pagato':'Pagato'}}
                </span>
              </p>
            </div>
          
            <!-- Items in the Order -->
            <div class="bg-white rounded-lg shadow-md mt-6 p-6 border">
              <h2 class="text-lg font-semibold text-gray-800">Articoli nel tuo ordine</h2>
              <div class="mt-4 space-y-4">
                @foreach ($order->articoli ?? [] as $item)
                  <div class="flex items-center">
                    @php
                        if(isset($item->product->FOTO)){
                            $FOTO = json_decode($item->product->FOTO);
                        }
                        $FOTO = isset($FOTO[0]) ? tenant_asset($FOTO[0]) : "https://via.placeholder.com/80";
                    @endphp
                    <img src="{{$FOTO}}" alt="Immagine del prodotto" class="w-20 h-20 object-cover rounded-md shadow">
                    <div class="ml-4 flex-grow">
                      <h3 class="text-gray-800 font-medium">{{$item->product->DESCRIZIONEBREVE ?? 'Descrizione non disponibile'}}</h3>
                      <p class="text-sm text-gray-600">Quantità: {{$item->qta ?? '0'}}</p>
                    </div>
                    <p class="text-gray-800 font-medium">{{$item->imponibile ?? '0'}}€</p>
                  </div>
                @endforeach
              </div>
            </div>
          
            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow-md mt-6 p-6 border">
              <h2 class="text-lg font-semibold text-gray-800">Indirizzo di spedizione</h2>
              <p class="mt-2 text-gray-600">{{ $order->nominativo_spedizione ?? 'Non disponibile' }}</p>
              <p class="text-gray-600">{{ $order->indirizzo_spedizione ?? 'Non disponibile' }}</p>
              <p class="text-gray-600">{{ $order->citta_spedizione ?? 'Non disponibile' }}, {{ $order->shipping_state ?? 'Non disponibile' }} {{ $order->cap_spedizione ?? 'Non disponibile' }}</p>
              <p class="text-gray-600">{{ $order->provincia_spedizione ?? 'Non disponibile' }}</p>

              <p class="text-gray-600 mt-2"><b>Telefono: </b>{{ $order->telefono ?? 'Non disponibile' }}</p>
              <p class="text-gray-600"><b>Email: </b>{{ $order->email ?? 'Non disponibile' }}</p>
            </div>
          </div>
        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
