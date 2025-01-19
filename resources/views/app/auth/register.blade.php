@section('title', 'Register')
<x-app-guest-layout>
    <div class="w-8/12 mx-auto py-10">
        <h2 class="text-3xl font-bold pb-5">CREATE YOUR ACCOUNT</h2>
        @include('app.auth.Partials.register-form')
    </div>
</x-app-guest-layout>
