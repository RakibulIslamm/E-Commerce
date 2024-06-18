<form method="POST" action="{{ $mode == 'edit' ? route('ecommerce.update', $settings) : route('ecommerce.store') }}"
    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full">
    @csrf
    {{-- @method($mode == 'edit' ? 'PUT' : 'POST') --}}
    @method($mode == 'edit' ? 'PUT' : 'POST')
    <!-- Part 1 -->
    <fieldset class="w-full space-y-3" {{ $mode == 'view' ? 'disabled' : '' }}>
        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-full">
                <label for="domain" class="block text-gray-700 text-sm font-bold mb-2">Domain</label>
                <input id="domain" name="domain" type="text" value="{{ old('domain', $settings->domain ?? '') }}"
                    required placeholder="Domain"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-full">
                <label for="auth_username" class="block text-gray-700 text-sm font-bold mb-2">Auth Username</label>
                <input id="auth_username" name="auth_username" type="text"
                    value="{{ old('auth_username', $settings->auth_username ?? '') }}" placeholder="Basic Auth Username"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-full">
                <label for="auth_password" class="block text-gray-700 text-sm font-bold mb-2">Auth Password</label>
                <input id="auth_password" name="auth_password" type="password"
                    value="{{ old('auth_password', $settings->auth_password ?? '') }}" placeholder="Basic Auth Password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>

        <!-- Rest of the form fields -->

        {{-- part 2 --}}
        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('email', e.target.value)"
                    value="{{ old('email', $settings['email'] ?? '') }}" id="email" type="email"
                    placeholder="Email" name="email" required>
            </div>

            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tax_code">
                    Tax Code
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('tax_code', e.target.value)"
                    value="{{ old('tax_code', $settings['tax_code'] ?? '') }}" id="tax_code" type="text"
                    placeholder="Tax Code" name="tax_code" required>
            </div>

            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                    Phone
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('phone', e.target.value)"
                    value="{{ old('phone', $settings['phone'] ?? '') }}" id="phone" type="text"
                    placeholder="Phone" name="phone" required>
            </div>
        </div>


        {{-- part 3 --}}
        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="rest_api_user">
                    Rest API User
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('rest_api_user', e.target.value)"
                    value="{{ old('rest_api_user', $settings['rest_api_user'] ?? '') }}" id="rest_api_user"
                    type="text" name="rest_api_user" placeholder="Rest API User" required>
            </div>

            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="rest_api_password">
                    Rest API Password
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('rest_api_password', e.target.value)"
                    value="{{ old('rest_api_password', $settings['rest_api_password'] ?? '') }}" id="rest_api_password"
                    type="password" name="rest_api_password" placeholder="Rest API Password" required>
            </div>

            <div class="w-6/12">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="business_type">
                    Business Type
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="business_type" name="business_type" required>
                    <option value="B2C"
                        {{ old('business_type', $settings['business_type'] ?? '') == 'B2C' ? 'selected' : '' }}>
                        B2C
                    </option>
                    <option value="B2B"
                        {{ old('business_type', $settings['business_type'] ?? '') == 'B2B' ? 'selected' : '' }}>
                        B2B
                    </option>
                    <option value="B2B Plus"
                        {{ old('business_type', $settings['business_type'] ?? '') == 'B2B Plus' ? 'selected' : '' }}>
                        B2B Plus
                    </option>
                </select>
            </div>
        </div>

        {{-- Part 4 --}}

        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="product_stock_display">
                    Product Stock Display
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="product_stock_display" name="product_stock_display" required>
                    <option value="Text Only"
                        {{ old('product_stock_display', $settings['product_stock_display'] ?? '') == 'Text Only' ? 'selected' : '' }}>
                        Text Only
                    </option>
                    <option value="Text + Quantity"
                        {{ old('product_stock_display', $settings['product_stock_display'] ?? '') == 'Text + Quantity' ? 'selected' : '' }}>
                        Text + Quantity
                    </option>
                    <option value="Do not display"
                        {{ old('product_stock_display', $settings['product_stock_display'] ?? '') == 'Do not display' ? 'selected' : '' }}>
                        Do not display
                    </option>
                </select>
            </div>

            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="registration_process">
                    Registration Process
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="registration_process" id="registration_process" required>
                    <option value="Optional"
                        {{ old('registration_process', $settings['registration_process'] ?? '') == 'Optional' ? 'selected' : '' }}>
                        Optional
                    </option>
                    <option value="Mandatory"
                        {{ old('registration_process', $settings['registration_process'] ?? '') == 'Mandatory' ? 'selected' : '' }}>
                        Mandatory
                    </option>
                    <option value="Mandatory with confirmation"
                        {{ old('registration_process', $settings['registration_process'] ?? '') == 'Mandatory with confirmation' ? 'selected' : '' }}>
                        Mandatory with confirmation
                    </option>
                </select>
            </div>

            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="offer_display">
                    Offer Display
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="offer_display" id="offer_display" required>
                    <option value="View cut price"
                        {{ old('offer_display', $settings['offer_display'] ?? '') == 'View cut price' ? 'selected' : '' }}>
                        View cut price
                    </option>
                    <option value="Do not display the cut price"
                        {{ old('offer_display', $settings['offer_display'] ?? '') == 'Do not display the cut price' ? 'selected' : '' }}>
                        Do not display the cut price
                    </option>
                </select>
            </div>

            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="decimal_places">
                    Decimal Places
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('decimal_places', $settings['decimal_places'] ?? '') }}" id="decimal_places"
                    type="number" name="decimal_places" placeholder="Decimal Places" min="0" required>
            </div>
        </div>


        {{-- Part 5 --}}
        <div class="flex justify-start items-start gap-10 pt-5">
            <div>
                <label class="block text-gray-700 text-sm font-bold" for="accepted_payments">
                    Accepted Payments
                </label>

                <div>
                    <input type="checkbox" class="mr-2 leading-tight" value="PayPal"
                        {{ in_array('PayPal', $settings['accepted_payments'] ?? []) ? 'checked' : '' }}
                        name="accepted_payments[]" id="paypal" />
                    <label class="text-sm" for="paypal">PayPal</label>
                </div>
                <div>
                    <input type="checkbox" class="mr-2 leading-tight" value="Bank Transfer"
                        {{ in_array('Bank Transfer', $settings['accepted_payments'] ?? []) ? 'checked' : '' }}
                        name="accepted_payments[]" id="bank_transfer" />
                    <label class="text-sm" for="bank_transfer">Bank Transfer</label>
                </div>
                <div>
                    <input type="checkbox" class="mr-2 leading-tight" value="Cash on Delivery"
                        {{ in_array('Cash on Delivery', $settings['accepted_payments'] ?? []) ? 'checked' : '' }}
                        name="accepted_payments[]" id="cash_on_delivery" />
                    <label class="text-sm" for="cash_on_delivery">Cash on Delivery</label>
                </div>
                <div>
                    <input type="checkbox" class="mr-2 leading-tight" value="collection_and_payment_on_site"
                        {{ in_array('collection_and_payment_on_site', $settings['accepted_payments'] ?? []) ? 'checked' : '' }}
                        name="accepted_payments[]" id="collection_and_payment_on_site" />
                    <label class="text-sm" for="collection_and_payment_on_site">Collection and payment on site</label>
                </div>
                {{-- <p>error</p> --}}
                @if ($errors->has('accepted_payments'))
                    <span class="text-red-500">{{ $errors->first('accepted_payments') }}</span>
                @endif
            </div>

            <div class="flex items-start gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold">
                        Price with VAT
                    </label>
                    <input type="checkbox" class="mr-2 leading-tight"
                        {{ isset($settings['price_with_vat']) && $settings['price_with_vat'] ? 'checked' : '' }}
                        name="price_with_vat" id="price_with_vat" value="1" />
                    <label class="text-sm" for="price_with_vat">Include VAT in price</label>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold">
                        Size and Color Options
                    </label>
                    <input type="checkbox" class="mr-2 leading-tight"
                        {{ isset($settings['size_color_options']) && $settings['size_color_options'] ? 'checked' : '' }}
                        name="size_color_options" id="size_color_options" value="1" />
                    <label class="text-sm" for="size_color_options">Enable size and color options</label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-start gap-4">
            @if ($mode == 'create' || $mode == 'edit')
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
            @else
                <button type="submit" disabled
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
            @endif


            @if ($mode == 'view' && ($user->role == 1 || $user->role == 2))
                <a href="{{ route('ecommerce.edit', $settings) }}"
                    class="text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline underline">Edit
                    Data</a>
            @endif

            @if ($mode == 'edit')
                <a href="{{ route('ecommerce.index') }}"
                    class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</a>
            @endif

            @if ($mode == 'edit' && $user->role == 1)
                <button
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    onclick="handleDelete({{ $settings }})">
                    Delete
                </button>
            @endif
        </div>
    </fieldset>
</form>

<form id="delete-form-{{ $settings->id ?? '' }}" action="{{ route('ecommerce.delete', $settings ?? '') }}"
    method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
