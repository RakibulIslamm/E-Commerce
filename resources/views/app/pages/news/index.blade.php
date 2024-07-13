@section('title', 'News')
{{-- @dd($breadcrumbs[0]->title) --}}
<x-app-guest-layout>
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'News']">
        <div class="w-full">
            <p>News goes here</p>
        </div>
    </x-page-layout>
</x-app-guest-layout>
