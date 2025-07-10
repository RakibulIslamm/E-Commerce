@section('title', 'Cambio password')
<x-app-layout>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <form method="post" action="{{ route('app.password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="update_password_current_password" :value="__('Password attuale')" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="mt-1 block w-full" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password" :value="__('Nuova Password')" />
                    <x-text-input id="update_password_password" name="password" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Conferma Password')" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                        type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 20000)"
                            class="text-sm text-gray-600">{{ __('Password Aggiornata') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
