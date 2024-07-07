@section('title', 'Corporate Data')
<x-app-layout>
    {{-- {{ dd($settings->domain) }} --}}
    @include('app.components.dashboard.corporate-data.brand')
    @include('app.components.dashboard.corporate-data.address')
    @include('app.components.dashboard.corporate-data.social')

</x-app-layout>
