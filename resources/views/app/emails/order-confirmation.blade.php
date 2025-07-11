<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma Ordine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #e7f3fe;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0;
        }
        .order-details, .product-summary, .shipping-info {
            margin-top: 20px;
        }
        .order-details h2, .product-summary h2, .shipping-info h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .details {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .details:last-child {
            border-bottom: none;
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .footer a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Grazie per il tuo ordine!</h1>
            <p>Il tuo ordine è stato effettuato con successo.</p>
        </div>

        <div class="order-details">
            <h2>Dettagli dell'Ordine</h2>
            <div class="details"><strong>ID Ordine:</strong><span> #{{$id}}</span></div>
            <div class="details">
                <strong>Data:</strong> 
                <span>{{ \Carbon\Carbon::parse($created_at)->locale('it')->translatedFormat('j F Y, H:i') }}</span>
            </div>
            <div class="details"><strong>Totale:</strong><span> €{{ number_format($totale_netto, 2) }}</span></div>
            <div class="details"><strong>Spese di spedizione:</strong><span> €{{ number_format($spese_spedizione, 2) }}</span></div>
            <div class="details"><strong>IVA:</strong><span> €{{ number_format($totale_iva, 2) }}</span></div>
            <div class="details"><strong>Spese contrassegno:</strong><span> €{{ number_format($cod_fee, 2) }}</span></div>
        </div>

        @php
            $user = auth()?->user();
            $discount = $user?->discount ?? 0;
        @endphp

        <div class="product-summary">
            <h2>Articoli nel tuo Ordine</h2>
            @foreach ($articoli as $item)
                @php
                    $unitPrice = $item['imponibile'];
                    $discountedUnitPrice = $unitPrice - ($unitPrice * $discount / 100);
                    $quantity = $item['qta'];
                    $subtotal = $unitPrice * $quantity;
                    $discountedTotal = $subtotal - ($subtotal * $discount / 100);
                @endphp

                <div class="product-item">
                    <div>
                        <strong style="margin-left: 10px;">{{ $item->product->DESCRIZIONEBREVE }}</strong>
                    </div>
                    <div style="text-align: right;">
                        <div>€{{ number_format($discountedUnitPrice, 2) }} x{{ $quantity }}</div>
                        @if($discount > 0)
                            <div>
                                <strong>€{{ number_format($discountedTotal, 2) }}</strong>
                            </div>
                        @else
                            <div><strong>€{{ number_format($subtotal, 2) }}</strong></div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="shipping-info">
            <h2>Indirizzo di Spedizione</h2>
            <p>{{ $nominativo_spedizione }}</p>
            <p>{{ $indirizzo_spedizione }}</p>
            <p>{{ $citta_spedizione }}, {{ $shipping_state }} {{ $cap_spedizione }}</p>
            <p>{{ $provincia_spedizione }}</p>
            <p><strong>Telefono:</strong> {{ $telefono }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
        </div>
    </div>
</body>
</html>
