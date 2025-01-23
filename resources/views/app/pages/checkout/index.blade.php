{{-- @dd($shipping_settings) --}}
<x-app-checkout-layout>
    @error('cap_not_available')
        <h3 class="bg-red-500 text-white py-2 rounded-md text-lg font-bold my-3 text-center">{{ $message }}</h3>
    @enderror
    <form action="{{ route('app.place-order') }}" method="POST"
        class="flex flex-col lg:flex-row items-start justify-between py-10 px-5 sm:px-10 lg:px-20 gap-10" onsubmit="disableSubmitButton()">
        @csrf
        <div class="flex-1">
            <div>
                <h4 class="text-xl">Informazioni contatto</h4>
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email address')" />
                    <x-text-input id="email" class="block w-full mt-1" type="text" name="email"
                        value="{{ $user->email ?? '' }}" required />
                </div>
            </div>
            <hr class="my-10">

            <div>
                <h4 class="text-xl">Dati di fatturazione</h4>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-full">
                            <x-input-label for="nominativo" :value="__('Nominativo')" />
                            <x-text-input id="nominativo" class="block w-full mt-1" type="text" name="nominativo"
                                value="{{ $user->name ?? '' }}" required />
                        </div>
                        <div class="w-full">
                            <x-input-label for="telefono" :value="__('Telefono')" />
                            <x-text-input id="telefono" class="block w-full mt-1" type="text" name="telefono"
                                value="{{ $user->telephone ?? '' }}" required />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="ragione_sociale" :value="__('Ragione Sociale')" />
                        <x-text-input id="ragione_sociale" class="block w-full mt-1" type="text"
                            name="ragione_sociale" value="{{ $user->business_name ?? '' }}" required />
                    </div>

                    <div>
                        <x-input-label for="indirizzo" :value="__('Indirizzo')" />
                        <x-text-input id="indirizzo" class="block w-full mt-1" type="text" name="indirizzo"
                            value="{{ $user->address ?? '' }}" required />
                    </div>
                    <div class="w-full">
                        <p class="text-red-500 italic text-sm" id="cap_error"></p>
                        <div class="w-full flex items-center gap-3">
                            <div class="w-full">
                                <x-input-label for="cap" :value="__('Cap')" />
                                <x-text-input id="cap" class="block w-full mt-1" type="text" name="cap"
                                    value="{{ $user->postal_code ?? '' }}" required />
                            </div>

                            <div class="w-full">
                                <label for="citta" class="block font-medium text-sm text-gray-700">Citta</label>
                                <select name="citta" id="citta"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                                    <option value="{{ $user->city ?? '' }}">{{ $user->city ?? 'Enter post code' }}
                                    </option>
                                </select>
                            </div>
                            <div class="w-full">
                                <x-input-label for="provincia" :value="__('Provincia')" />
                                <x-text-input id="provincia" class="block w-full mt-1" type="text" name="provincia"
                                    value="{{ $user->province ?? '' }}" required />
                            </div>

                            {{-- <div class="sr-only">
                        <x-input-label for="stato" :value="__('Stato')" />
                        <x-text-input id="stato" class="block w-full mt-1" type="text" name="stato"
                            value='1' required />
                    </div> --}}
                        </div>
                    </div>

                </div>
            </div>
            <hr class="my-6">



            <label for="shipping" class="peer cursor-pointer flex items-center gap-2 my-2">
                <input class="cursor-pointer" id="shipping" type="checkbox" name="" />
                <span>Indirizzo di spedizione diverso</span>
            </label>
            <div class="hidden peer-has-[:checked]:block">
                <h4 class="text-xl">Informazioni sulla spedizione (se diverse dalla fatturazione)</h4>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <div>
                            <x-input-label for="nominativo_spedizione" :value="__('Nominativo')" />
                            <x-text-input id="nominativo_spedizione" class="block w-full mt-1" type="text"
                                name="nominativo_spedizione" />
                        </div>
                        <div>
                            <x-input-label for="telefono_spedizione" :value="__('Telefono')" />
                            <x-text-input id="telefono_spedizione" class="block w-full mt-1" type="text"
                                name="telefono_spedizione" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="indirizzo_spedizione" :value="__('Indirizzo')" />
                        <x-text-input id="indirizzo_spedizione" class="block w-full mt-1" type="text"
                            name="indirizzo_spedizione" />
                    </div>
                    <div class="flex items-center gap-3">
                        <div>
                            <x-input-label for="cap_spedizione" :value="__('Cap')" />
                            <x-text-input id="cap_spedizione" class="block w-full mt-1" type="text"
                                name="cap_spedizione" />
                        </div>

                        <div>
                            <label for="citta_spedizione"
                                class="block font-medium text-sm text-gray-700">Città</label>
                            <select name="citta_spedizione" id="citta_spedizione"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1">
                                <option value="">Inserisci il codice postale</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="provincia_spedizione" :value="__('Provincia')" />
                            <x-text-input id="provincia_spedizione" class="block w-full mt-1" type="text"
                                name="provincia_spedizione" />
                        </div>

                    </div>
                    <div>
                        <x-input-label for="note" :value="__('Note')" />
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full"
                            name="note" id="note" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <hr class="my-6">
        </div>


        <div class="flex-1 w-full">
            <div>
                <label for="spedizione" class="block text-lg font-medium text-gray-900 mb-2">Courier</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @if (isset($shipping_settings))
                        @foreach ($shipping_settings as $index => $item)
                            <div class="relative w-full ">
                                <input type="radio" name="spedizione" value="{{$item->courier}}" id="shipping_{{$item->courier}}"
                                    class="hidden checked:block absolute top-4 right-4 peer/{{$item->courier}}" 
                                    {{$index === 0 ? 'checked' : ''}} required>
                                <div class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition peer-checked/{{$item->courier}}:border-blue-500 peer-checked/{{$item->courier}}:shadow">
                                    <label for="shipping_{{$item->courier}}" class="block w-full cursor-pointer">
                                        <span class="block text-lg font-semibold">{{$item->courier}}</span>
                                        {{-- <span class="block text-sm text-gray-500"><b>Cash on delivery fee:</b> {{$item->cod_fee}}€</span> --}}
                                        <span class="block text-sm text-gray-500"><b>Vat:</b> {{$item->vat_rate}}%</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Not found</p>
                    @endif
                </div>
            </div>
            <h2 class="text-xl mt-5">Order summary</h2>
            <div class="mt-4 bg-white p-10 rounded-lg shadow-md space-y-10">
                <div id="items-container">
                    <div class="flex justify-between items-center">
                        <p>Prodotto</p>
                        <p>SubTotale</p>
                    </div>


                    <hr class="my-3">
                    @if (session('cart'))
                        @foreach (session('cart') as $id => $details)
                            <div class="flex items-center justify-between text-gray-500">
                                <p>{{ $details['name'] }} x {{ $details['quantity'] }}</p>
                                <p>{{ $details['price'] * $details['quantity'] }}€</p>
                            </div>
                        @endforeach
                    @else
                        <p>Il tuo carrello è vuoto</p>
                    @endif
                    <hr class="my-3">
                </div>

                @php
                    $total = 0;
                    $vat = 0;
                    // dd($details['price'] * $details['quantity'] * (15 / 100));
                    if (session('cart')) {
                        foreach (session('cart') as $id => $details) {
                            $total += $details['price'] * $details['quantity'];
                            // number/total*100 (parcentage formula)
                            $vat += ($details['price'] * $details['quantity'] * $details['vat']) / 100;
                        }
                    }
                    $total = number_format((float) $total, 2, '.', '');
                    $vat = number_format((float) $vat, 2, '.', '');
                    $grand_total = number_format((float) $vat + $total, 2, '.', '');
                @endphp



                <div>
                    <div>
                        <div class="flex justify-between items-center text-gray-600">
                            <p>SubTotale</p>
                            <p>{{ $total }}€</p>
                        </div>
                        <hr class="my-3">
                    </div>

                    <div>
                        <div class="flex justify-between items-center text-gray-600">
                            <p>Spedizione</p>
                            <p id="shipping_cost"></p>
                            <input type="text" name="spese_spedizione" id="shipping_cost_input" class=" sr-only"
                                value="">
                        </div>
                        <hr class="my-3">
                    </div>

                    <div>
                        <div class="flex justify-between items-center text-gray-600">
                            <p>Tassa di pagamento in contrassegno</p>
                            <p id="cod_fee"></p>
                            <input type="text" name="cod_fee" id="cod_fee_input" class=" sr-only"
                                value="0">
                        </div>
                        <hr class="my-3">
                    </div>

                    <div>
                        <div class="flex justify-between items-center text-gray-600">
                            <p>Iva</p>
                            <p>{{ $vat }}€</p>
                        </div>
                        <hr class="my-3">
                    </div>

                    <div>
                        <div class="flex justify-between items-center font-semibold text-gray-800 text-lg">
                            <p>Somma totale</p>
                            <p id="grand_total">{{ $grand_total }}€</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="px-10 py-3 rounded-lg border w-full mt-4 bg-slate-800 text-white" id="order_submit_btn">Effettuare l'ordine</button>
        </div>
    </form>

    <script>
        function disableSubmitButton() {
            // Disable the submit button to prevent double-clicks
            var submitButton = document.getElementById('order_submit_btn');
            submitButton.disabled = true;
            submitButton.innerText = 'Processing...';
        }

        let grandTotal = {{ $grand_total }};
        let total = {{ $total }};
        document.getElementById('grand_total').innerText = `${grandTotal.toFixed(2)}€`;

        const shippings = @json($shipping_settings) || [];
        document.querySelectorAll('input[name="spedizione"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const shipping = shippings.find(item=> item.courier === this.value)
                const vatRate = parseFloat(shipping.vat_rate)/100;
                let shippingCost = 0;
                const cod_fee = parseInt(shipping.cod_fee);
                // rules currently static only for italy 
                const rules = shipping?.rules?.filter(item => item.zone === 'italy')

                for(const rule of rules){
                    if(parseFloat(total) < parseInt(rule?.threshold)){
                        shippingCost = parseFloat(parseInt(rule.fee)*(1+vatRate));
                    }
                }

                document.getElementById('shipping_cost').innerText = `${shippingCost.toFixed(2) > 0 ? `${shippingCost.toFixed(2)}€` : "Free shipping"}`;

                document.getElementById('shipping_cost_input').value = parseFloat(
                    `${shippingCost.toFixed(2)}`);
                    
                document.getElementById('cod_fee').innerText = `${cod_fee}€`;

                document.getElementById('cod_fee_input').value = parseFloat(
                    `${cod_fee}`);

                grandTotal = {{ $grand_total }} + shippingCost + cod_fee;
                document.getElementById('grand_total').innerText = `${grandTotal.toFixed(2)}€`;
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const firstShipping = document.querySelector('input[name="spedizione"]:first-child');
            if (firstShipping) {
                firstShipping.checked = true;
                firstShipping.dispatchEvent(new Event('change'));
            }
        });



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
        const capError = document.getElementById('cap_error');

        function handleLocation(value) {
            capError.innerText = '';
            fetch(`/api/location/${value}`)
                .then(res => res.json())
                .then(data => {
                    // console.log(data);
                    if (data?.locations?.length) {
                        province.value = data?.locations[0]?.province;
                        // state_code.value = data?.locations[0]?.state_code;
                        city.innerHTML = '';
                        data?.locations?.forEach(location => {
                            const option = document.createElement('option');
                            option.value = location?.place;
                            option.innerText = location?.place;
                            city.appendChild(option);
                        })
                    } else {
                        capError.innerText = 'Location not found';
                        city.innerHTML = '';
                        province.value = '';
                    }

                })
                .catch(error => {
                    console.log(error);
                })
        }


        function debounce(func, delay, id) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        const itemsContainer = document.getElementById('items-container');
        // getCart()
        async function getCart(loadingId = '') {
            // const loadingElement = document.getElementById(loadingId);
            if (isUserLoggedIn()) {
                // loadingElement && loadingElement.classList.remove('hidden')
                const res = await fetch('/get-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();

                const container = document.createElement('div');
                const productItem = document.createElement('div');
                productItem.classList.add("flex", "items-center", "justify-between", "text-gray-500")

                for (const item of data?.cart_items) {
                    const total = parseFloat(item.quantity * item?.product?.PRE1IMP).toFixed(2);
                    const itemStr = JSON.stringify({
                        ...item,
                        product: {
                            ...item.product,
                            FOTO: null,
                            DESCRIZIONEESTESA: ''
                        }
                    });

                    productItem.innerHTML = `
                <p>${item?.product?.DESCRIZIONEBREVE} x ${item.quantity}</p>
                <p>$${total}</p>
                <input type="text" class="sr-only" name="items[]" value="${itemStr}" />
                `

                    container.appendChild(productItem);
                }

                itemsContainer.appendChild(container);
                const hr = document.createElement('hr');
                hr.classList.add('my-3')
                itemsContainer.appendChild(hr);

                // loadingElement && loadingElement.classList.remove('hidden')

            } else {
                const cartData = localStorage.getItem('cart');
                if (cartData) {
                    // loadingElement && loadingElement.classList.remove('hidden')
                    const res = await fetch('/get-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cart: cartData
                        })
                    });
                    const data = await res.json();
                    // loadingElement && loadingElement.classList.remove('hidden')
                }
            }
        }

        // Checking user logged in or not
        function isUserLoggedIn() {
            return {{ Auth::check() ? 'true' : 'false' }};
        }
    </script>
</x-app-checkout-layout>
