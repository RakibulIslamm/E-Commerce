<form method="POST" action="{{ route('app.register') }}" class="w-full space-y-4">
    @csrf
    @if (isset($from))
        <input type="text" name="from" value="{{ $from }}" class="sr-only">
    @endif

    <div class="flex flex-col md:flex-row items-start md:gap-4 gap-2">
        <div class="w-full md:w-8/12">
            <x-input-label for="name" :value="__('Nome*')" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="w-full md:w-4/12">
            <x-input-label for="date_of_birth" :value="__('Data di nascita*')" />
            <x-text-input id="date_of_birth" class="block w-full" type="date" name="date_of_birth" :value="old('date_of_birth')"
                required autofocus />
            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-start md:gap-4 gap-2">
        <div class="w-full md:w-6/12">
            <x-input-label for="email" :value="__('Email*')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="w-full md:w-6/12">
            <x-input-label for="telephone" :value="__('Telefono*')" />
            <x-text-input id="telephone" class="block w-full" type="text" name="telephone" :value="old('telephone')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-start md:gap-4 gap-2">
        <div class="w-full md:w-6/12">
            <x-input-label for="password" :value="__('Password*')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="w-full md:w-6/12">
            <x-input-label for="password_confirmation" :value="__('Conferma Password*')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>

    <div class="w-full">
        <x-input-label for="address" :value="__('Indirizzo*')" />
        <x-text-input id="address" class="block w-full" type="text" name="address" :value="old('address')" required
            autocomplete="username" />
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <div class="w-full">
        <p class="text-red-500 italic text-sm" id="post_code_error"></p>
        <div class="flex flex-col md:flex-row items-start md:gap-4 gap-2">
            <div class="w-full md:w-4/12">
                <x-input-label for="postal_code" :value="__('Codice postale*')" />
                <x-text-input id="postal_code" class="block w-full mt-1" type="text" name="postal_code" required />
            </div>

            <div class="w-full md:w-4/12">
                <label for="city" class="block font-medium text-sm text-gray-700">Città</label>
                <select name="city" id="city" required
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                    <option value="">Scegli il codice postale</option>
                </select>
            </div>

            <div class="w-full md:w-4/12">
                <x-input-label for="province" :value="__('Provincia')" />
                <x-text-input id="province" class="block w-full mt-1" type="text" name="province" required />
            </div>
        </div>
    </div>

    <h3 class="pt-5 text-2xl font-semibold uppercase">Dati di fatturazione</h3>

    <div class="flex flex-col md:flex-row items-start md:gap-4 gap-2">
        <div class="w-full md:w-6/12">
            <x-input-label for="tax_id" :value="__('CF')" />
            <x-text-input id="tax_id" class="block w-full" type="text" name="tax_id" :value="old('tax_id')"
                autocomplete="username" />
            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
        </div>

        <div class="w-full md:w-6/12">
            <x-input-label for="business_name" :value="__('Denominazione*')" />
            <x-text-input id="business_name" class="block w-full" type="text" name="business_name"
                :value="old('business_name')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-start md:gap-4 gap-2">
        <div class="w-full md:w-4/12">
            <x-input-label for="vat_number" :value="__('Partita iva*')" />
            <x-text-input id="vat_number" class="block w-full" type="text" name="vat_number" :value="old('vat_number')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('vat_number')" class="mt-2" />
        </div>

        <div class="w-full md:w-4/12">
            <x-input-label for="pec_address" :value="__('PEC')" />
            <x-text-input id="pec_address" class="block w-full" type="text" name="pec_address" :value="old('pec_address')"
                autocomplete="username" />
            <x-input-error :messages="$errors->get('pec_address')" class="mt-2" />
        </div>

        <div class="w-full md:w-4/12">
            <x-input-label for="sdi_code" :value="__('SDI codice*')" />
            <x-text-input id="sdi_code" class="block w-full" type="text" name="sdi_code" :value="old('sdi_code')"
                autocomplete="username" />
            <x-input-error :messages="$errors->get('sdi_code')" class="mt-2" />
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-end mt-4 gap-2 sm:gap-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('app.login') }}">
            {{ __('Già registrato?') }}
        </a>

        <x-primary-button class="ms-4">
            {{ __('Registrati') }}
        </x-primary-button>
    </div>
</form>

@if ($errors->has('email'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Email già registrata',
                text: 'L’indirizzo email inserito è già in uso. Per favore, usa un’email diversa.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
        });
    </script>
@endif

<script>
    document.getElementById('postal_code').addEventListener('keypress', (e) => {
        if (e.key == 'Enter') {
            e.preventDefault();
            const code = document.getElementById('postal_code')?.value;
            if (!code) {
                console.log("Please provide zip/post code");
                e.target.focus();
                return;
            }
            handleLocation(code);
            e.target.blur()
        }
    })

    document.getElementById('postal_code').addEventListener('change', (e) => {
        console.log(e.target.value);
        handleLocation(e?.target?.value);
    })

    const city = document.getElementById('city');
    const province = document.getElementById('province');
    const postCodeError = document.getElementById('post_code_error');

    function handleLocation(value) {
        postCodeError.innerText = '';
        fetch(`/api/location/${value}`)
            .then(res => res.json())
            .then(data => {
                if (data?.locations?.length) {
                    province.value = data?.locations[0]?.province;
                    city.innerHTML = '';
                    data?.locations?.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location?.place;
                        option.innerText = location?.place;
                        city.appendChild(option);
                    })
                } else {
                    console.log("Posizione non trovata");
                    postCodeError.innerText = 'Posizione non trovata';
                    city.innerHTML = ''
                    province.value = ''
                }
            })
            .catch(error => {
                console.log(error);
            })
    }
</script>
