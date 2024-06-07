@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>
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
</body>

</html>
