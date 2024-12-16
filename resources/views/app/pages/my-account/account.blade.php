@section('title', 'Account')
{{-- @dd($user) --}}
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Indirizzo di fatturazione']">
        <x-my-account-layout>
            <form method="POST" action="{{ route('app.account.my-data') }}" class="w-8/12">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <h3 class="text-2xl font-semibold uppercase">DATI PERSONALI</h3>
                    @if (isset($from))
                        <input type="text" name="from" value="{{ $from }}" class="sr-only">
                    @endif

                    <div class="flex items-start gap-4">
                        <!-- Name -->
                        <div class="w-8/12">
                            <x-input-label for="name" :value="__('Nome*')" />
                            <x-text-input id="name" class="block w-full" type="text" name="name"
                                :value="old('name', $user->name ?? 'Nome non disponibile')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Date Of Birth --}}
                        <div class="w-4/12">
                            <x-input-label for="date_of_birth" :value="__('Data di Nascita*')" />
                            <x-text-input id="date_of_birth" class="block w-full" type="date" name="date_of_birth"
                                :value="old('date_of_birth', $user->date_of_birth ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <!-- Email Address -->
                        <div class="w-full">
                            <x-input-label for="email" :value="__('Email*')" />
                            <x-text-input id="email" class="block w-full" type="email" name="email"
                                :value="old('email', $user->email ?? 'Email non disponibile')" required autocomplete="username" disabled />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- @dd($user); --}}

                        <!-- Telephone -->
                        <div class="w-full">
                            <x-input-label for="telephone" :value="__('Telefono*')" />
                            <x-text-input id="telephone" class="block w-full" type="text" name="telephone"
                                :value="old('telephone', $user->telephone ?? 'Telefono non disponibile')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="space-y-4 mt-6">
                    <h3 class="text-2xl font-semibold uppercase">INDIRIZZO DI SPEDIZIONE</h3>
                    <!-- Address -->
                    <div class="w-full">
                        <x-input-label for="address" :value="__('Indirizzo*')" />
                        <x-text-input id="address" class="block w-full" type="text" name="address"
                            :value="old('address', $user->address ?? 'Indirizzo non disponibile')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <p class="text-red-500 italic text-sm" id="post_code_error"></p>
                        <div class="flex items-start gap-4">
                            <!-- Postal Code -->
                            <div class="w-full">
                                <x-input-label for="postal_code" :value="__('Codice Postale*')" />
                                <x-text-input id="postal_code" class="block w-full mt-1" type="text"
                                    :value="old('postal_code', $user->postal_code ?? '')" name="postal_code" required />
                            </div>

                            <!-- City -->
                            <div class="w-full">
                                <label for="city" class="block font-medium text-sm text-gray-700">Città</label>
                                <select name="city" id="city"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                                    <option value="{{ $user->city }}" selected>{{ $user->city ?? 'Città non disponibile' }}</option>
                                </select>
                            </div>

                            <!-- Province -->
                            <div class="w-full">
                                <x-input-label for="province" :value="__('Provincia')" />
                                <x-text-input id="province" class="block w-full mt-1" type="text" name="province"
                                    :value="old('province', $user->province ?? 'Provincia non disponibile')" required />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="space-y-4 mt-6">
                    <h3 class="pt-5 text-2xl font-semibold uppercase">INFORMAZIONI DI FATTURAZIONE</h3>
                    <div class="flex items-start gap-4">
                        <!-- Tax Id -->
                        <div class="w-full">
                            <x-input-label for="tax_id" :value="__('Codice Fiscale')" />
                            <x-text-input id="tax_id" class="block w-full" type="text" name="tax_id"
                                :value="old('tax_id', $user->tax_id ?? '')" autocomplete="username" />
                            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                        </div>

                        <!-- Business Name -->
                        <div class="w-full">
                            <x-input-label for="business_name" :value="__('Ragione Sociale*')" />
                            <x-text-input id="business_name" class="block w-full" type="text" name="business_name"
                                :value="old('business_name', $user->business_name ?? '')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
                        </div>

                    </div>


                    <div class="flex items-start gap-4">
                        <!-- Vat number -->
                        <div class="w-full">
                            <x-input-label for="vat_number" :value="__('Numero di Partita IVA*')" />
                            <x-text-input id="vat_number" class="block w-full" type="text" name="vat_number"
                                :value="old('vat_number', $user->vat_number ?? '')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('vat_number')" class="mt-2" />
                        </div>

                        <!-- PEC -->
                        <div class="w-full">
                            <x-input-label for="pec_address" :value="__('PEC')" />
                            <x-text-input id="pec_address" class="block w-full" type="text" name="pec_address"
                                :value="old('pec_address', $user->pec_address ?? '')" autocomplete="username" />
                            <x-input-error :messages="$errors->get('pec_address')" class="mt-2" />
                        </div>

                        <!-- SDI Code -->
                        <div class="w-full">
                            <x-input-label for="sdi_code" :value="__('Codice SDI*')" />
                            <x-text-input id="sdi_code" class="block w-full" type="text" name="sdi_code"
                                :value="old('sdi_code', $user->sdi_code ?? '')" autocomplete="username" />
                            <x-input-error :messages="$errors->get('sdi_code')" class="mt-2" />
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Aggiorna') }}
                    </x-primary-button>
                </div>
            </form>
        </x-my-account-layout>
        <script>
            // set location
            // const debouncedHandleLocation = debounce(handleLocation, 1000);
            const postalCode = document.getElementById('postal_code');
            const city = document.getElementById('city');
            const province = document.getElementById('province');
            const postCodeError = document.getElementById('post_code_error');

            if (postalCode.value) {
                handleLocation(postalCode.value)
            }

            document.getElementById('postal_code').addEventListener('keypress', (e) => {
                if (e.key == 'Enter') {
                    e.preventDefault();

                    if (!postalCode.value) {
                        console.log("Inserire il CAP");
                        e.target.focus();
                        return;
                    }
                    city.innerHTML = '';
                    handleLocation(postalCode.value);
                    e.target.blur()
                }

            })

            document.getElementById('postal_code').addEventListener('change', (e) => {
                city.innerHTML = '';
                handleLocation(e?.target?.value);
            })

            function handleLocation(value) {
                postCodeError.innerText = '';
                fetch(`/api/location/${value}`)
                    .then(res => res.json())
                    .then(data => {
                        // console.log(data);
                        if (data?.locations?.length) {
                            province.value = data?.locations[0]?.province;
                            // city.innerHTML = '';
                            data?.locations?.forEach(location => {
                                const option = document.createElement('option');
                                option.value = location?.place;
                                option.innerText = location?.place;
                                city.appendChild(option);
                            })
                        } else {
                            console.log("Località non trovata");
                            postCodeError.innerText = 'Località non trovata';
                            city.innerHTML = ''
                            province.value = ''
                        }

                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        </script>
    </x-page-layout>
</x-app-guest-layout>
