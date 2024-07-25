@section('title', 'Billing Address')
@dd($user)
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Billing Address']">
        <x-my-account-layout>
            <div class="mt-4 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-full">
                        <x-input-label for="nominativo" :value="__('Nominativo')" />
                        <x-text-input id="nominativo" class="block w-full mt-1" type="text" name="nominativo"
                            value="{{ old('nominativo') }}" required />
                    </div>
                    <div class="w-full">
                        <x-input-label for="telefono" :value="__('Telefono')" />
                        <x-text-input id="telefono" class="block w-full mt-1" type="text" name="telefono"
                            required />
                    </div>
                </div>

                <div>
                    <x-input-label for="ragione_sociale" :value="__('Ragione Sociale')" />
                    <x-text-input id="ragione_sociale" class="block w-full mt-1" type="text" name="ragione_sociale"
                        required />
                </div>

                <div>
                    <x-input-label for="indirizzo" :value="__('Indirizzo')" />
                    <x-text-input id="indirizzo" class="block w-full mt-1" type="text" name="indirizzo" required />
                </div>

                <div class="flex items-center gap-3">
                    <div>
                        <x-input-label for="cap" :value="__('Cap')" />
                        <x-text-input id="cap" class="block w-full mt-1" type="text" name="cap" required />
                    </div>

                    <div>
                        <label for="citta" class="block font-medium text-sm text-gray-700">Citta</label>
                        <select name="citta" id="citta"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                            <option value="">Enter post code</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="provincia" :value="__('Provincia')" />
                        <x-text-input id="provincia" class="block w-full mt-1" type="text" name="provincia"
                            required />
                    </div>

                    <div class="sr-only">
                        <x-input-label for="stato" :value="__('Stato')" />
                        <x-text-input id="stato" class="block w-full mt-1" type="text" name="stato"
                            value='1' required />
                    </div>
                </div>

            </div>
        </x-my-account-layout>
        <script>
            // set location
            // const debouncedHandleLocation = debounce(handleLocation, 1000);
            document.getElementById('cap').addEventListener('keypress', (e) => {
                if (e.key == 'Enter') {
                    e.preventDefault();
                    const code = document.getElementById('cap')?.value;

                    if (!code) {
                        console.log("Please provide zip/post code");
                        e.target.focus();
                        return;
                    }

                    handleLocation(code);
                    e.target.blur()
                }

            })

            document.getElementById('cap').addEventListener('change', (e) => {
                handleLocation(e?.target?.value);
            })
            const city = document.getElementById('citta');
            const province = document.getElementById('provincia');
            const state_code = document.getElementById('stato');

            function handleLocation(value) {
                fetch(`/api/location/${value}`)
                    .then(res => res.json())
                    .then(data => {
                        // console.log(data);
                        if (data?.locations?.length) {
                            province.value = data?.locations[0]?.province;
                            state_code.value = data?.locations[0]?.state_code;
                            city.innerHTML = '';
                            data?.locations?.forEach(location => {
                                const option = document.createElement('option');
                                option.value = location?.place;
                                option.innerText = location?.place;
                                city.appendChild(option);
                            })
                        } else {
                            console.log("Location not found");
                        }

                    })
            }
        </script>
    </x-page-layout>
</x-app-guest-layout>
