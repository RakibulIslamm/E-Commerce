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

// dd($site_settings);

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

@section('title', 'Contact')
<x-app-guest-layout>
    <div class="p-20 bg-slate-100">
        <div class="flex items-start justify-between gap-10">
            <div class="w-5/12 text-right flex flex-col gap-4 items-end text-gray-800">
                <h2 class="text-5xl font-bold text-right leading-snug">Parliamo insieme di qualcosa di grandioso</h2>
                <div class="flex flex-col items-end gap-1 mt-4">
                    <p class="flex items-center gap-1">{{ $email ?? 'example@gmail.com' }} <x-heroicon-s-envelope
                            class="w-5 h-5" /></p>
                    <p class="flex items-center gap-1">{{ $telephone ?? '+134757585' }} <x-heroicon-c-phone
                            class="w-5 h-5" /></p>
                    <p class="flex items-center gap-1">{{ $street ?? '123 Street 487 House' }} <x-heroicon-s-map-pin
                            class="w-5 h-5" /></p>
                </div>

                <div class="flex items-center gap-3 mt-10">
                    <x-bxl-linkedin-square class="w-6 h-6" />
                    <x-bxl-twitter class="w-8 h-8" />
                    <x-bxl-facebook-square class="w-6 h-6" />
                    <x-bxl-instagram-alt class="w-6 h-6" />
                </div>
            </div>
            @include('app.components.contact.Partials.form')
        </div>
    </div>
</x-app-guest-layout>
