<x-app-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full h-full flex justify-center items-center">
        @include('app.auth.Partials.login-form')
    </div>
</x-app-guest-layout>
