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

@section('title', 'Contact')
<x-app-guest-layout>
    <div class="p-6 md:p-10 bg-slate-100">
        <div class="flex flex-col md:flex-row items-start justify-between gap-6 md:gap-10">
            <!-- Left Section -->
            <div class="w-full md:w-5/12 text-center md:text-right flex flex-col gap-4 items-center md:items-end text-gray-800">
                <h2 class="text-3xl md:text-3xl font-bold leading-snug text-center md:text-right lg:w-10/12">
                    Parliamo insieme di qualcosa di grandioso
                </h2>
                <div class="flex flex-col items-center md:items-end gap-2">
                    <p class="flex items-center gap-2 text-sm md:text-base">
                        <x-heroicon-s-envelope class="w-5 h-5" />
                        {{ $email ?? 'example@gmail.com' }}
                    </p>
                    <p class="flex items-center gap-2 text-sm md:text-base">
                        <x-heroicon-c-phone class="w-5 h-5" />
                        {{ $telephone ?? '+134757585' }}
                    </p>
                    <p class="flex items-center gap-2 text-sm md:text-base">
                        <x-heroicon-s-map-pin class="w-5 h-5" />
                        {{ $street ?? '123 Street 487 House' }}
                    </p>
                </div>

                <div class="flex items-center gap-4 mt-3">
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

            <!-- Contact Form -->
            <div class="w-full md:w-7/12">
                @include('app.components.contact.Partials.form')
            </div>
        </div>
        @if($map_iframe)
        <div class="mt-8">
            <div class="mt-2 border rounded-lg overflow-hidden">
                {!! $map_iframe !!}
            </div>
        </div>
        @endif
    </div>
</x-app-guest-layout>
