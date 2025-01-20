<x-app-checkout-layout>
    <div class="p-5 sm:p-10 lg:px-20 flex items-start">
        <div class="w-4/12 flex flex-col items-center gap-10">
            <div class="bg-slate-200 p-5 w-full">
                <h2 class="text-2xl py-3 font-semibold">Sei un utente registrato?</h2>
                <div class="w-full">
                    @include('app.auth.Partials.login-form', ['from' => 'checkout'])
                </div>
            </div>
            <p class="text-xl">OR</p>
            <form action="{{ route('app.checkout') }}" method="POST">
                @csrf
                <input type="text" class="sr-only" name="proceed" value="proceed-checkout">
                <x-secondary-button type='submit'>
                    Procedi senza registrarti
                </x-secondary-button>
            </form>
        </div>
        <div class="px-8 w-8/12">
            <h2 class="text-2xl py-3 font-semibold">Sei un nuovo cliente e vuoi registrarti?</h2>
            <div class="w-full">
                @include('app.auth.Partials.register-form', ['from' => 'checkout'])
            </div>
        </div>
    </div>
</x-app-checkout-layout>
