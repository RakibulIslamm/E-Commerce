<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuovo Ordine Ricevuto</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        .container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { color: #333; }
        .details, .product { margin: 10px 0; }
        .product { border-bottom: 1px solid #ddd; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nuovo Ordine Ricevuto</h2>
        <p><strong>ID Ordine:</strong> #{{ $id }}</p>
        <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($created_at)->locale('it')->translatedFormat('j F Y, H:i') }}</p>
        <p><strong>Totale Netto:</strong> €{{ number_format($totale_netto, 2) }}</p>
        <p><strong>Spese di spedizione:</strong> €{{ number_format($spese_spedizione, 2) }}</p>
        <p><strong>IVA:</strong> €{{ number_format($totale_iva, 2) }}</p>
        <p><strong>Spese contrassegno:</strong> €{{ number_format($cod_fee, 2) }}</p>

        <h3>Prodotti:</h3>
        @foreach ($articoli as $item)
            <div class="product">
                <p><strong>{{ $item->product->DESCRIZIONEBREVE }}</strong></p>
                <p>€{{ number_format($item['imponibile'], 2) }} x {{ $item['qta'] }} = €{{ number_format($item['imponibile'] * $item['qta'], 2) }}</p>
            </div>
        @endforeach

        <h3>Dati Cliente:</h3>
        <p><strong>Nome:</strong> {{ $nominativo_spedizione }}</p>
        <p><strong>Indirizzo:</strong> {{ $indirizzo_spedizione }}, {{ $citta_spedizione }} ({{ $provincia_spedizione }}), {{ $cap_spedizione }} - {{ $shipping_state }}</p>
        <p><strong>Telefono:</strong> {{ $telefono }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
    </div>
</body>
</html>
