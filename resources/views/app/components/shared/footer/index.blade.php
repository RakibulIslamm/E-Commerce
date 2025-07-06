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

<footer class="w-full bg-slate-50 text-gray-700 body-font px-5 sm:px-10 lg:px-20">
    <div class="container mx-auto flex flex-col md:flex-row flex-wrap md:items-start py-10 lg:py-20 gap-y-10">
        <!-- Company Info -->
        <div class="w-full md:w-1/3 md:text-left">
            <h2 class="relative mb-4 text-lg font-semibold uppercase tracking-wider text-gray-900 
                after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-blue-600">
                Indirizzo
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
                <hr class="mt-5">
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

        <!-- Links Sections -->
        <div class="flex flex-wrap flex-grow gap-y-10 w-full md:w-2/3">
            <div class="w-full sm:w-1/2 lg:w-1/3 px-4">
                <h2 class="relative mb-4 text-lg font-semibold uppercase tracking-wider text-gray-900
                    after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-blue-600">
                    Shop
                </h2>
                <ul class="space-y-2">
                    <li><a href="/products" class="text-gray-500 hover:text-gray-900">Prodotti</a></li>
                    <li><a href="/cart" class="text-gray-500 hover:text-gray-900">Carrello</a></li>
                </ul>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/3 px-4">
                <h2 class="relative mb-4 text-lg font-semibold uppercase tracking-wider text-gray-900
                    after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-blue-600">
                    Informazioni
                </h2>
                <ul class="space-y-2">
                    <li><a href="/agency" class="text-gray-500 hover:text-gray-900">Azienda</a></li>
                    <li><a href="/account/summary" class="text-gray-500 hover:text-gray-900">Account</a></li>
                    <li><a href="/register" class="text-gray-500 hover:text-gray-900">Registrati</a></li>
                </ul>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/3 px-4">
                <h2 class="relative mb-4 text-lg font-semibold uppercase tracking-wider text-gray-900
                    after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-blue-600">
                    Servizi
                </h2>
                <ul class="space-y-2">
                    <li><a href="/contact" class="text-gray-500 hover:text-gray-900">Contatti</a></li>
                    <li><a href="/condition-for-sale" class="text-gray-500 hover:text-gray-900">Condizioni di vendita</a></li>
                    <li><a href="/privacy-and-cookie" class="text-gray-500 hover:text-gray-900">Privacy e cookie policy</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t mt-10">
        <div class="container mx-auto px-5 py-4 text-center">
            <p class="text-sm text-gray-700">&copy; 2024 Tutti i diritti riservati</p>
        </div>
    </div>
</footer>
