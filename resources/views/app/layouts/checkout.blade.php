<?php

// $cart = session()->get('cart');
// dd($cart);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" bg-slate-50">

    @if (isset($success))
        @dd($success)
        @dd($order)
    @endif

    <div class="px-20 py-2 flex items-center justify-between border-b">
        <a href="/" class="flex items-center gap-2">
            <img class="h-12 w-auto object-cover" src="{{ '/images/logo.png' }}" alt="">
            {{-- <h2 class="text-lg font-bold">Company Name</h2> --}}
        </a>

        <div class="flex items-center gap-5 text-sm text-gray-500">
            <a href="{{ route('app.cart') }}">Cart</a>
            <x-ri-arrow-drop-right-fill class="w-5 h-5" />
            <p class="{{ Request::is('cart/checkout') ? 'font-bold text-xl text-gray-700' : '' }} text-gray-500">
                Checkout</p>
            <x-ri-arrow-drop-right-fill class="w-5 h-5" />
            <p
                class="{{ Request::is('cart/checkout/confirm') ? 'font-bold text-xl text-gray-700' : '' }} text-gray-500">
                Confirmation</p>
        </div>
    </div>
    {{ $slot }}
</body>

</html>
