@section('title', 'Dati aziendali')
<x-app-layout>
    @include('app.components.dashboard.corporate-data.brand')
    @include('app.components.dashboard.corporate-data.address')
    @include('app.components.dashboard.corporate-data.smtp')
    @include('app.components.dashboard.corporate-data.social')
</x-app-layout>
