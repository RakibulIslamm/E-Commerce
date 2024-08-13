<x-app-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-4/12 py-10 mx-auto">
        <h2 class="mb-4 text-2xl font-semibold">Login</h2>
        @include('app.auth.Partials.login-form')
    </div>
</x-app-guest-layout>
