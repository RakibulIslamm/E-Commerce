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
$socialLinks = [];

if (isset($site_settings->social_links)) {
    $socialLinks = $site_settings->social_links;
}

if (isset($site_settings->corporate_data)) {
    $corporate_data = $site_settings->corporate_data;

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

<footer class="w-full text-gray-700 body-font lg:px-20 sm:px-10 px-5 bg-slate-50">
    <div
        class="container flex flex-col-reverse flex-wrap lg:py-20 py-10 mx-auto md:items-center lg:items-start md:flex-row md:flex-no-wrap">
        <div class="w-64 sm:flex-grow mx-auto text-center md:mx-0 md:text-left">
            {{-- <a class="flex items-center justify-center font-medium text-gray-900 title-font md:justify-start">
                <img class="w-16 h-16" src="/images/logo.png" alt="">
            </a>
            <p class="mt-2 text-sm text-gray-500">Breve descrizione qui</p> --}}
            <div class="w-full">
                <h2 class="mb-3 text-lg font-medium tracking-widest text-gray-900 uppercase title-font">Indirizzo</h2>
                <nav class="list-none space-y-4">
                    @if ($street || $city || $country)
                        <li class="text-center lg:text-left flex items-center gap-2">
                            <x-heroicon-s-map-pin class="w-6 h-6" />
                            <span>Indirizzo: </span>
                            <span class="text-gray-500 cursor-pointer hover:text-gray-900">{{$street}} {{$city}} {{$country}}</span>
                        </li>
                    @endif
                    @if ($email)
                        <li class="text-center lg:text-left flex items-center gap-2">
                            <x-heroicon-s-envelope class="w-6" />
                            <span>Email: </span>
                            <span class="text-gray-500 cursor-pointer hover:text-gray-900">{{$email}}</span>
                        </li>
                    @endif
                    @if ($telephone)
                        <li class="text-center lg:text-left flex items-center gap-2">
                            <x-heroicon-s-phone class="w-6" />
                            <span>Telefono: </span>
                            <span class="text-gray-500 cursor-pointer hover:text-gray-900">{{$telephone}}</span>
                        </li>
                    @endif
                </nav>
            </div>
            <div class="mt-4">
                <div class="inline-flex justify-center mt-2 sm:ml-auto sm:mt-0 sm:justify-start gap-2">
                    @if (!empty($socialLinks))
                        @foreach ($socialLinks as $name => $url)
                            <a href="{{ $url }}" target="_blank" class="flex items-center gap-2">
                                @switch($name)
                                    @case('facebook')
                                        <x-bxl-facebook-square class="w-7 h-7" />
                                    @break

                                    @case('twitter')
                                        <x-bxl-twitter class="w-7 h-7" />
                                    @break

                                    @case('instagram')
                                        <x-bxl-instagram-alt class="w-7 h-7" />
                                    @break

                                    @case('linkedin')
                                        <x-bxl-linkedin-square class="w-7 h-7" />
                                    @break

                                    @default
                                        {{ null }}
                                    @break
                                @endswitch
                                {{-- {{ ucfirst($name) }} --}}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="flex flex-wrap flex-grow mt-10 text-center md:pl-20 md:mt-0 md:text-left">
            <div class="w-full px-4 lg:w-1/3 md:w-1/2">
                <h2 class="mb-3 text-lg font-medium tracking-widest text-gray-900 uppercase title-font">Shop</h2>
                <nav class="mb-10 list-none">
                    <li class="mt-3">
                        <a href="/products" class="text-gray-500 cursor-pointer hover:text-gray-900">Prodotti</a>
                    </li>
                    <li class="mt-3">
                        <a href="/cart" class="text-gray-500 cursor-pointer hover:text-gray-900">Carrello</a>
                    </li>
                </nav>
            </div>
            <div class="w-full px-4 lg:w-1/3 md:w-1/2">
                <h2 class="mb-3 text-lg font-medium tracking-widest text-gray-900 uppercase title-font">Informazioni</h2>
                <nav class="mb-10 list-none">
                    <li class="mt-3">
                        <a href="/agency" class="text-gray-500 cursor-pointer hover:text-gray-900">Azienda</a>
                    </li>
                    <li class="mt-3">
                        <a href="/account/summary" class="text-gray-500 cursor-pointer hover:text-gray-900">Account</a>
                    </li>
                    <li class="mt-3">
                        <a href="/register" class="text-gray-500 cursor-pointer hover:text-gray-900">Registrati</a>
                    </li>
                </nav>
            </div>
            <div class="w-full px-4 lg:w-1/3 md:w-1/2">
                <h2 class="mb-3 text-lg font-medium tracking-widest text-gray-900 uppercase title-font">Servizi</h2>
                <nav class="mb-10 list-none">
                    <li class="mt-3">
                        <a href="/contact" class="text-gray-500 cursor-pointer hover:text-gray-900">Contatti</a>
                    </li>
                    <li class="mt-3">
                        <a href="/condition-for-sale" class="text-gray-500 cursor-pointer hover:text-gray-900">Condizioni di vendita</a>
                    </li>
                    {{-- <li class="mt-3">
                        <a class="text-gray-500 cursor-pointer hover:text-gray-900">Privacy e cookie policy</a>
                    </li> --}}
                </nav>
            </div>
        </div>
    </div>
    <div class="border-t">
        <div class="container px-5 py-4 mx-auto">
            <p class="text-sm text-gray-700 capitalize text-center">&copy; 2024 Tutti i diritti riservati</p>
        </div>
    </div>
</footer>
