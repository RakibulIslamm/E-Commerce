@section('title', 'Account')

<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Indirizzo di fatturazione']">
        <x-my-account-layout>
            <form method="POST" action="{{ route('app.account.my-data') }}" class="w-full md:w-8/12">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- DATI PERSONALI -->
                    <h3 class="text-2xl font-semibold uppercase">Dati Personali</h3>

                    @if (isset($from))
                        <input type="hidden" name="from" value="{{ $from }}">
                    @endif

                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <!-- Name -->
                        <div class="w-full md:w-8/12">
                            <x-input-label for="name" :value="__('Nome*')" />
                            <x-text-input id="name" class="block w-full" type="text" name="name"
                                :value="old('name', auth()?->user()?->name ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Date of Birth -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="date_of_birth" :value="__('Data di Nascita*')" />
                            <x-text-input id="date_of_birth" class="block w-full" type="date" name="date_of_birth"
                                :value="old('date_of_birth', auth()?->user()?->date_of_birth ?? '')" required />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <!-- Email -->
                        <div class="w-full md:w-6/12">
                            <x-input-label for="email" :value="__('Email*')" />
                            <x-text-input id="email" class="block w-full" type="email" name="email"
                                :value="old('email', auth()?->user()?->email ?? '')" required disabled />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Telephone -->
                        <div class="w-full md:w-6/12">
                            <x-input-label for="telephone" :value="__('Telefono*')" />
                            <x-text-input id="telephone" class="block w-full" type="text" name="telephone"
                                :value="old('telephone', auth()?->user()?->telephone ?? '')" required />
                            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                        </div>
                    </div>

                    <!-- INDIRIZZO DI SPEDIZIONE -->
                    <h3 class="text-2xl font-semibold uppercase pt-5">Indirizzo di Spedizione</h3>

                    <!-- Address -->
                    <div>
                        <x-input-label for="address" :value="__('Indirizzo*')" />
                        <x-text-input id="address" class="block w-full" type="text" name="address"
                            :value="old('address', auth()?->user()?->address ?? '')" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <p class="text-red-500 italic text-sm" id="post_code_error"></p>

                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <!-- Postal Code -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="postal_code" :value="__('Codice Postale*')" />
                            <x-text-input id="postal_code" class="block w-full" type="text" name="postal_code"
                                :value="old('postal_code', auth()?->user()?->postal_code ?? '')" required />
                        </div>

                        <!-- City -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="city" :value="__('Città')" />
                            <select name="city" id="city"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                                <option value="{{ auth()?->user()?->city }}" selected>{{ auth()?->user()?->city ?? '' }}</option>
                            </select>
                        </div>

                        <!-- Province -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="province" :value="__('Provincia')" />
                            <x-text-input id="province" class="block w-full" type="text" name="province"
                                :value="old('province', auth()?->user()?->province ?? '')" required />
                        </div>
                    </div>

                    <!-- INFORMAZIONI DI FATTURAZIONE -->
                    <h3 class="text-2xl font-semibold uppercase pt-5">Informazioni di Fatturazione</h3>

                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <!-- Tax Id -->
                        <div class="w-full md:w-6/12">
                            <x-input-label for="tax_id" :value="__('Codice Fiscale')" />
                            <x-text-input id="tax_id" class="block w-full" type="text" name="tax_id"
                                :value="old('tax_id', auth()?->user()?->tax_id ?? '')" />
                            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                        </div>

                        <!-- Business Name -->
                        <div class="w-full md:w-6/12">
                            <x-input-label for="business_name" :value="__('Ragione Sociale*')" />
                            <x-text-input id="business_name" class="block w-full" type="text" name="business_name"
                                :value="old('business_name', auth()?->user()?->business_name ?? '')" required />
                            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <!-- VAT Number -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="vat_number" :value="__('Numero di Partita IVA*')" />
                            <x-text-input id="vat_number" class="block w-full" type="text" name="vat_number"
                                :value="old('vat_number', auth()?->user()?->vat_number ?? '')" required />
                            <x-input-error :messages="$errors->get('vat_number')" class="mt-2" />
                        </div>

                        <!-- PEC -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="pec_address" :value="__('PEC')" />
                            <x-text-input id="pec_address" class="block w-full" type="text" name="pec_address"
                                :value="old('pec_address', auth()?->user()?->pec_address ?? '')" />
                            <x-input-error :messages="$errors->get('pec_address')" class="mt-2" />
                        </div>

                        <!-- SDI Code -->
                        <div class="w-full md:w-4/12">
                            <x-input-label for="sdi_code" :value="__('Codice SDI*')" />
                            <x-text-input id="sdi_code" class="block w-full" type="text" name="sdi_code"
                                :value="old('sdi_code', auth()?->user()?->sdi_code ?? '')" />
                            <x-input-error :messages="$errors->get('sdi_code')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <x-primary-button>
                            {{ __('Aggiorna') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </x-my-account-layout>

        <script>
            const postalCode = document.getElementById('postal_code');
            const city = document.getElementById('city');
            const province = document.getElementById('province');
            const postCodeError = document.getElementById('post_code_error');

            if (postalCode.value) {
                handleLocation(postalCode.value)
            }

            postalCode.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (!postalCode.value) {
                        postCodeError.innerText = 'Inserire il CAP';
                        e.target.focus();
                        return;
                    }
                    city.innerHTML = '';
                    handleLocation(postalCode.value);
                    e.target.blur();
                }
            });

            postalCode.addEventListener('change', (e) => {
                city.innerHTML = '';
                handleLocation(e.target.value);
            });

            function handleLocation(value) {
                postCodeError.innerText = '';
                fetch(`/api/location/${value}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data?.locations?.length) {
                            province.value = data.locations[0].province;
                            data.locations.forEach(location => {
                                const option = document.createElement('option');
                                option.value = location.place;
                                option.innerText = location.place;
                                city.appendChild(option);
                            });
                        } else {
                            postCodeError.innerText = 'Località non trovata';
                            city.innerHTML = '';
                            province.value = '';
                        }
                    })
                    .catch(() => {
                        postCodeError.innerText = 'Errore durante il recupero del CAP';
                    });
            }
        </script>
    </x-page-layout>
</x-app-guest-layout>
