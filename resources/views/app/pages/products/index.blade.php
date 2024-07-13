@section('title', 'Products')
<x-app-guest-layout>
    {{-- @dd($breadcrumbs) --}}
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'Shop']">
        <div class="w-full">
            <p>Products goes here</p>
        </div>
    </x-page-layout>
</x-app-guest-layout>
