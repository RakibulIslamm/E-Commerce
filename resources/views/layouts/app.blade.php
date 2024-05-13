@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name')}} @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-yellow-50 min-h-screen flex items-start relative">
        @include('layouts.sidebar')            
            <main class="w-full h-full">
                <div class="w-full h-[60px] shadow-sm flex justify-between items-center bg-white border-b border-l sticky top-0 px-5">
                    @if ($user->role == 5)
                        <div>
                            <a href="/request-an-ecommerce" class="px-4 py-1 bg-slate-200 rounded">Request an ecommerce</a>
                        </div>
                    @endif
                    <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                </div>
                <div class="w-full h-full flex justify-center items-center">
                    {{$slot}}
                </div>
            </main>
        </div>
    </body>
</html>
