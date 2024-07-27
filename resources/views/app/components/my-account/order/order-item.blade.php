<div class="p-3 rounded-md bg-slate-50 border">
    <div class="flex items-center gap-8">
        <div class="flex items-center gap-2">
            <p class="text-xl">ORDER NO.</p>
            <a class="text-xl underline tracking-widest" href="#">#{{ $order->id }}</a>
        </div>
        <div class="flex items-center gap-2">
            <div class="px-5 py-1 border rounded-md inline-block text-sm">
                @if ($order->stato == -1)
                    <span>Pending</span>
                @elseif($order->stato == 0)
                    <span>Taken</span>
                @elseif($order->stato == 1)
                    <span>Preparation</span>
                @elseif($order->stato == 2)
                    <span>Shipped</span>
                @endif
            </div>
            <div>
                @if ($order->pagato == 0)
                    <span class="bg-yellow-500 px-5 py-1 border rounded-md inline-block text-sm text-white">Unpaid</span>
                @elseif($order->pagato == 1)
                    <span class="bg-blue-500 px-5 py-1 border rounded-md inline-block text-sm text-white">Paid</span>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-1">
        <h2>Order Items:</h2>
        @foreach ($order_items as $item)
            @php
                $FOTO = json_decode($item->product->FOTO)[0] ?? '';
            @endphp

            <div class="flex gap-3">
                <img class="w-24 border"
                    src="{{ $FOTO ? 'data:image/png;base64,' . $FOTO : 'https://psediting.websites.co.in/obaju-turquoise/img/product-placeholder.png' }}"
                    alt="">
                <div>
                    <p class="text-lg">{{ $item->product->DESCRIZIONEBREVE ?? '' }}</p>
                    <div class="flex items-center gap-1">
                        <p>${{ $item->price }}</p>
                        <span>x</span>
                        <p>{{ $item->quantity }}</p>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            <p>Sub total: <span>$100</span></p>
            <p>Vat: <span>$100</span></p>
            <p>Shipping cost: <span>$100</span></p>
            <p>Total: <span>$100</span></p>
        </div>
    </div>
</div>
