@php
    $tenant = tenant();
    // Check if brand_info exists, then if name exists and is not empty
    $brand_title = !empty($tenant->brand_info['name'] ?? null) ? $tenant->brand_info['name'] : 'Ecommerce';
@endphp

@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ $brand_title ?? config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.bubble.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased flex items-start justify-start bg-gray-100">
    @include('app.layouts.Partials.sidebar')
    <main class="w-[calc(100%_-_320px)] h-full">
        {{-- px-10 bg-white border shadow-sm rounded-xl sticky top-0 --}}
        <div class="py-4 mx-8 border-b">
            @include('app.layouts.Partials.header')
        </div>
        <div class="mx-8 my-4 relative">
            {{ $slot }}
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script type="module">
        commonUtils.sessionMessageClose();

        if (localStorage.getItem('cart') && isUserLoggedIn()) {
            fetch('/set-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart: localStorage.getItem('cart')
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('cart');
                    }
                });
        }

        function isUserLoggedIn() {
            return {{ Auth::check() ? 'true' : 'false' }};
        }
    </script>
</body>

</html>
