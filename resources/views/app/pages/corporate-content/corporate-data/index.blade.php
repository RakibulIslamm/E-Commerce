@section('title', 'Corporate Data')
<x-app-layout>
    {{-- {{ dd($settings->domain) }} --}}
    @include('app.pages.corporate-content.corporate-data.Partials.brand')


    @include('app.pages.corporate-content.corporate-data.Partials.address')
    @include('app.pages.corporate-content.corporate-data.Partials.social')

</x-app-layout>
