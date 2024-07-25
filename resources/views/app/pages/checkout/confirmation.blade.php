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
    <div class="px-20 py-5 flex items-center justify-between border-b">
        <a href="/" class="flex items-center gap-2">
            <img class="h-12 w-auto object-cover" src="{{ '/images/logo.png' }}" alt="">
            {{-- <h2 class="text-lg font-bold">Company Name</h2> --}}
        </a>

        <div class="flex items-center gap-5 text-sm text-gray-500">
            <a href="{{ route('app.cart') }}">Cart</a>
            <x-ri-arrow-drop-right-fill class="w-5 h-5" />
            <p class="">Checkout</p>
            <x-ri-arrow-drop-right-fill class="w-5 h-5" />
            <p class="font-bold text-gray-700">Confirmation</p>
        </div>
    </div>

    {{-- @dd($order)
    @dd($success) --}}

    <div class="w-full h-[300px] flex justify-center items-center flex-col gap-2">
        <x-lucide-circle-check class="w-20 h-20 text-blue-500" />
        <h1 class="text-3xl text-blue-500 font-bold">Order placed successfully</h1>
        <h3 class="text-xl text-gray-700">Your Order Number is: <span
                class=" underline font-semibold">{{ $order->id }}</span></h3>
        <a href="/" class="flex items-center gap-2 px-5 py-1"><x-bx-arrow-back class="w-5 h-5" /> Go Home</a>
    </div>

</body>


</html>
