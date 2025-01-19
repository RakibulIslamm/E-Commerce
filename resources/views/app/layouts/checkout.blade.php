<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50">
    {{-- Navigation Bar --}}
    <div class="px-5 py-2 sm:px-10 lg:px-20 flex items-center justify-between border-b">
        <a href="/" class="flex items-center gap-2">
            <img class="h-8 sm:h-10 lg:h-12 w-auto object-cover" src="{{ '/images/logo.png' }}" alt="Logo">
            {{-- <h2 class="text-lg font-bold">Company Name</h2> --}}
        </a>

        <div class="flex items-center gap-3 sm:gap-5 text-xs sm:text-sm text-gray-500">
            <a href="{{ route('app.cart') }}">Cart</a>
            <x-ri-arrow-drop-right-fill class="w-4 h-4 sm:w-5 sm:h-5" />
            <p class="{{ Request::is('cart/checkout') ? 'font-bold text-gray-700 sm:text-base' : '' }} text-gray-500">
                Checkout</p>
            <x-ri-arrow-drop-right-fill class="w-4 h-4 sm:w-5 sm:h-5" />
            <p class="{{ Request::is('cart/checkout/confirm') ? 'font-bold text-gray-700 sm:text-base' : '' }} text-gray-500">
                Confirmation</p>
        </div>
    </div>

    {{-- Slot for Content --}}
    <div>
        {{ $slot }}
    </div>
</body>

</html>
