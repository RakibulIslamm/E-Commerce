<?php

$city = null;
$state = null;
$country = null;
$street = null;
$email = null;
$telephone = null;
$fax = null;
$iban = null;
$map_iframe = null;

$socialLinks = null;

if (isset(tenant()?->social_links)) {
    $socialLinks = tenant()?->social_links;
}

if (isset(tenant()?->corporate_data)) {
    $corporate_data = tenant()?->corporate_data;

    $city = isset($corporate_data['city']) ? $corporate_data['city'] : null;
    $state = isset($corporate_data['state']) ? $corporate_data['state'] : null;
    $country = isset($corporate_data['country']) ? $corporate_data['country'] : null;
    $street = isset($corporate_data['street']) ? $corporate_data['street'] : null;
    $email = isset($corporate_data['email']) ? $corporate_data['email'] : null;
    $telephone = isset($corporate_data['telephone']) ? $corporate_data['telephone'] : null;
    $fax = isset($corporate_data['fax']) ? $corporate_data['fax'] : null;
    $iban = isset($corporate_data['iban']) ? $corporate_data['iban'] : null;
    $map_iframe = isset($corporate_data['map_iframe']) ? $corporate_data['map_iframe'] : null;
}

?>

@section('title', 'Contatti')
<x-app-guest-layout>
    <style>
        .iframe-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 45%;
        }
        
        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
    <div class="p-6 md:p-10 bg-slate-100">
        <div class="flex flex-col md:flex-row items-start justify-between gap-6 md:gap-10">
            <!-- Left Section -->
            <div class="w-full md:w-5/12 md:text-right flex flex-col gap-4 items-center md:items-end text-gray-800">
                <h2 class="text-3xl md:text-3xl font-bold leading-snug text-center md:text-right lg:w-10/12">
                    Contattaci!
                </h2>
                <ul class="space-y-3">
                    @if ($street || $city || $country)
                        <li class="flex items-start gap-3">
                            <div class="p-1 bg-blue-100 rounded-full">
                                <x-heroicon-s-map-pin class="w-5 h-5 text-blue-600" />
                            </div>
                            <div class="text-gray-500 hover:text-gray-900 leading-snug">
                                @if ($street)
                                    {{ $street }}<br>
                                @endif
                                @if ($city || $country)
                                    {{ $city }} {{ $country }}
                                @endif
                            </div>
                        </li>
                    @endif

                    @if ($email)
                        <li class="flex items-start gap-3">
                            <div class="p-1 bg-blue-100 rounded-full">
                                <x-heroicon-s-envelope class="w-5 h-5 text-blue-600" />
                            </div>
                            <div class="text-gray-500 hover:text-gray-900 break-words">{{ $email }}</div>
                        </li>
                    @endif

                    @if ($telephone)
                        <li class="flex items-start gap-3">
                            <div class="p-1 bg-blue-100 rounded-full">
                                <x-heroicon-s-phone class="w-5 h-5 text-blue-600" />
                            </div>
                            <div class="text-gray-500 hover:text-gray-900">{{ $telephone }}</div>
                        </li>
                    @endif
                </ul>

                <!-- Social Links -->
                @if (!empty($socialLinks))
                    <hr class="">
                    <div class="flex justify-center md:justify-start gap-3 mt-5">
                        @foreach ($socialLinks as $name => $url)
                            <a href="{{ $url }}" target="_blank" class="text-gray-500 hover:text-gray-900 transition transform hover:scale-110">
                                @switch($name)
                                    @case('facebook')
                                        <x-bxl-facebook-square class="w-6 h-6" />
                                        @break
                                    @case('instagram')
                                        <x-bxl-instagram-alt class="w-6 h-6" />
                                        @break
                                    @case('linkedin')
                                        <x-bxl-linkedin-square class="w-6 h-6" />
                                        @break
                                    @case('twitter')
                                        <x-fab-x-twitter class="w-6 h-6" />
                                        @break
                                    @default
                                @endswitch
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Contact Form -->
            <div class="w-full md:w-7/12">
                @if (session()->has('success'))
                    <div class="px-10 py-2 bg-green-500 text-white font-semibold flex items-center justify-between"
                        id="session_status">
                        <p>{{ session('success') }}</p>
                        <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="px-10 py-2 bg-red-500 text-white font-semibold flex items-center justify-between"
                        id="session_status">
                        <p>{{ session('error') }}</p>
                        <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                    </div>
                @endif
                
                {{-- Contact Form --}}
                @include('app.components.contact.Partials.form')
            </div>
        </div>
        @if($map_iframe)
        <div class="mt-8">
            <div class="iframe-container mt-2 border rounded-lg">
                {!! $map_iframe !!}
            </div>
        </div>
        @endif
    </div>
</x-app-guest-layout>
