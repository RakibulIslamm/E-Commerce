<x-app-layout>
    {{-- {{ dd($settings->domain) }} --}}
    <h1 class="text-xl font-bold">Settings</h1>
    <h1 class="">Username: {{ $settings->auth_username }}</h1>
    <h1 class="">Domain: {{ $settings->domain }}</h1>
    <h1 class="">Email: {{ $settings->email }}</h1>
    <h1 class="">Business Type: {{ $settings->business_type }}</h1>
    <h1 class="">Phone: {{ $settings->phone }}</h1>
    <h1 class="">Created Date: {{ $settings->created_at }}</h1>

</x-app-layout>
