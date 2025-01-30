<x-app-checkout-layout>
    @if ($success)
    <div class="max-w-4xl mx-auto p-6">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-green-600">Grazie per il tuo ordine!</h1>
                <p class="mt-2 text-gray-600">Il tuo ordine è stato effettuato con successo.</p>
            </div>
        </div>
    
        <!-- Order Details Section -->
        <div class="bg-white rounded-lg shadow-md mt-6 p-6">
            <h2 class="text-lg font-semibold text-gray-800">Dettagli dell'Ordine</h2>
            <div class="mt-4">
                <div class="flex justify-between items-center border-b py-3">
                    <p class="text-gray-600">ID Ordine</p>
                    <p class="font-medium text-gray-800">#{{$order->id}}</p>
                </div>
                <div class="flex justify-between items-center border-b py-3">
                    <p class="text-gray-600">Data</p>
                    <div class="font-medium text-gray-800">
                        <p class="text-sm">{{ \Carbon\Carbon::parse($order->created_at)->locale('it')->translatedFormat('j F Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center border-b py-3">
                    <p class="text-gray-600">Totale</p>
                    <p class="font-medium text-gray-800">€{{ number_format($order->totale_netto, 2) }}</p>
                </div>
                <div class="flex justify-between items-center border-b py-3">
                    <p class="text-gray-600">Spese di spedizione</p>
                    <p class="font-medium text-gray-800">€{{ number_format($order->spese_spedizione, 2) }}</p>
                </div>
                <div class="flex justify-between items-center border-b py-3">
                    <p class="text-gray-600">IVA</p>
                    <p class="font-medium text-gray-800">€{{ number_format($order->totale_iva, 2) }}</p>
                </div>
                <div class="flex justify-between items-center py-3">
                    <p class="text-gray-600">Spese contrassegno</p>
                    <p class="font-medium text-gray-800">€{{ number_format($order->cod_fee, 2) }}</p>
                </div>
            </div>
        </div>
    
        <!-- Product Summary Section -->
        <div class="bg-white rounded-lg shadow-md mt-6 p-6">
            <h2 class="text-lg font-semibold text-gray-800">Articoli nel tuo Ordine</h2>
            <div class="mt-4 space-y-4">
                @foreach ($order->order_items as $item)
                    <div class="flex items-center">
                        <!-- Product Image (Placeholder) -->
                        @php
                            if(isset($item->product->FOTO)){
                                $FOTO = json_decode($item->product->FOTO);
                            }
                            $FOTO = isset($FOTO[0]) ? tenant_asset($FOTO[0]) : "https://via.placeholder.com/80";
                        @endphp
                        <img src="{{$FOTO}}" alt="Immagine del Prodotto" class="w-20 h-20 object-cover rounded-md shadow">
                        
                        <div class="ml-4 flex-grow">
                            <h3 class="text-gray-800 font-medium">{{$item->product->DESCRIZIONEBREVE}}</h3>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-gray-800 font-medium">€{{ number_format($item['price'], 2) }}</p>
                            <p class="text-gray-600">x{{ $item['quantity'] }}</p>
                            <p class="text-gray-800 font-medium">€{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    
        <!-- Shipping Address Section -->
        <div class="bg-white rounded-lg shadow-md mt-6 p-6">
            <h2 class="text-lg font-semibold text-gray-800">Indirizzo di Spedizione</h2>
            <p class="mt-2 text-gray-600">{{ $order->nominativo_spedizione }}</p>
            <p class="text-gray-600">{{ $order->indirizzo_spedizione }}</p>
            <p class="text-gray-600">{{ $order->citta_spedizione }}, {{ $order->shipping_state }} {{ $order->cap_spedizione }}</p>
            <p class="text-gray-600">{{ $order->provincia_spedizione }}</p>

            <p class="text-gray-600 mt-2"><b>Telefono: </b>{{ $order->telefono }}</p>
            <p class="text-gray-600"><b>Email: </b>{{ $order->email }}</p>
        </div>
    
        <!-- Footer Section -->
        <div class="text-center mt-8">
            <a href="/" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Continua a fare acquisti
            </a>
        </div>
    </div>
    @elseif(!$success)
        <div class="max-w-4xl mx-auto p-6 flex flex-col items-center">
            <div class="bg-white rounded-lg shadow-md p-6 w-full">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-red-700">Qualcosa è andato storto</h1>
                    <p class="text-gray-800">{{ isset($message) ? $message : 'Si è verificato un errore imprevisto. Riprova più tardi.' }}</p>
                </div>
            </div>
            <a href="/" class="inline-block mt-3 px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Torna alla Home
            </a>
        </div>
    @endif
</x-app-checkout-layout>

<script>
    const order = @json($order);
    // console.log(order);
</script>
