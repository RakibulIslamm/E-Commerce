@section('title', 'Registrati')
<x-app-guest-layout>
    <div class="lg:w-8/12 px-5 mx-auto py-10">
        <h2 class="text-3xl font-bold pb-5">CREA IL TUO ACCOUNT</h2>
        @include('app.auth.Partials.register-form')
    </div>
</x-app-guest-layout>
