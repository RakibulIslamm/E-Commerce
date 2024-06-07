@section('title', 'General Settings')
<x-app-layout>
    {{-- {{ dd($settings->domain) }} --}}
    @include('app.settings.general.Partials.brand')


    @include('app.settings.general.Partials.address')
    @include('app.settings.general.Partials.social')

</x-app-layout>
