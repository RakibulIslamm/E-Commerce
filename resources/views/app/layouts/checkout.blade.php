@php
    $brand_info = tenant()?->brand_info;
    $favicon = isset($brand_info['favicon']) ? asset($brand_info['favicon']) : url('/images/favicon.png');
    $logo = isset($brand_info['logo']) ? $brand_info['logo'] : '/images/logo.png';

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    <link rel="icon" href="{{ $favicon }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50">
    {{-- Navigation Bar --}}
    <div class="px-5 py-2 sm:px-10 lg:px-20 flex items-center justify-between border-b">
        <a href="/" class="flex items-center gap-2">
            <img class="h-8 sm:h-10 lg:h-12 w-auto object-cover" src="{{ $logo ?? '/images/logo.png' }}" alt="Logo">
        </a>

        <div class="flex items-center gap-3 sm:gap-5 text-xs sm:text-sm text-gray-500">
            <a href="{{ route('app.cart') }}">Carrello</a>
            <x-ri-arrow-drop-right-fill class="w-4 h-4 sm:w-5 sm:h-5" />
            <p class="{{ Request::is('cart/checkout') ? 'font-bold text-gray-700 sm:text-base' : '' }} text-gray-500">
                Checkout</p>
            <x-ri-arrow-drop-right-fill class="w-4 h-4 sm:w-5 sm:h-5" />
            <p class="{{ Request::is('cart/checkout/confirm') ? 'font-bold text-gray-700 sm:text-base' : '' }} text-gray-500">
                Conferma</p>
        </div>
    </div>

    {{-- Slot for Content --}}
    <div>
        {{ $slot }}
    </div>
</body>

</html>
