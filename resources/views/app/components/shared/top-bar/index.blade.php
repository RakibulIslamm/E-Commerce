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

<div class="flex h-10 items-center justify-between bg-sky-500 px-20 text-sm font-medium text-gray-100 relative z-50">
    <div class="flex items-center gap-8">
        <p class="flex items-center gap-2"><x-heroicon-s-envelope class="w-4 h-4" />
            @if (isset($email))
                {{ $email }}
            @else
                example@mail.com
            @endif
        </p>
        <p class="flex items-center gap-2"><x-heroicon-s-phone class="w-4 h-4" /> {{ $telephone }}</p>
    </div>
    <div class="flex items-center gap-4">
        <x-heroicon-s-user class="w-5 h-5" />
        <x-heroicon-s-heart class="w-5 h-5" />
    </div>
</div>
