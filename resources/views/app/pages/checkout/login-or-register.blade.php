<x-app-checkout-layout>
    <div class="p-5 sm:p-10 lg:px-20 flex flex-col lg:flex-row gap-10">
        <!-- Left Column -->
        <div class="w-full lg:w-5/12 flex flex-col items-center gap-6">
            <div class="bg-slate-200 p-5 w-full">
                <h2 class="text-2xl py-3 font-semibold text-center lg:text-left">
                    Sei un utente registrato?
                </h2>
                <div class="w-full">
                    @include('app.auth.Partials.login-form', ['from' => 'checkout'])
                </div>
            </div>

            <p class="text-xl text-center lg:text-left">oppure</p>

            <form action="{{ route('app.checkout') }}" method="GET" class="w-full text-center lg:text-left">
                @csrf
                <input type="hidden" name="proceed" value="proceed-checkout">
                <x-secondary-button type="submit">
                    Procedi senza registrarti
                </x-secondary-button>
            </form>
        </div>

        <!-- Right Column -->
        <div class="w-full lg:w-7/12 px-0 lg:px-8">
            <h2 class="text-2xl py-3 font-semibold text-center lg:text-left">
                Sei un nuovo cliente e vuoi registrarti?
            </h2>
            <div class="w-full">
                @include('app.auth.Partials.register-form', ['from' => 'checkout'])
            </div>
        </div>
    </div>
</x-app-checkout-layout>
