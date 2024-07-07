<div class="w-full p-5 bg-white rounded-lg shadow border mt-4">
    <form method="POST" action="{{ route('app.corporate-content.ecommerce.update') }}">
        @csrf
        @method('PUT')
        <div class="flex justify-between items-center pb-2">
            <h2 class="text-xl font-semibold">Ecommerce Info</h2>
            <div class="flex justify-end gap-2">
                <a href="{{ route('app.corporate-content.ecommerce') }}" type="button" id="cancel-edit-address"
                    class="px-5 py-1 border rounded bg-red-500 text-white">Cancel</a>
                <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Update</button>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Domain</span>
                <span class="flex-[20px] font-semibold">:</span>
                <input id="domain" name="domain" type="text" value="{{ old('domain', $settings->domain ?? '') }}"
                    required placeholder="Domain" disabled
                    class="shadow appearance-none border rounded flex-[500px] py-2 px-3 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Email</span>
                <span class="flex-[20px] font-semibold">:</span>
                <input
                    class="shadow appearance-none border rounded flex-[500px] py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('email', e.target.value)"
                    value="{{ old('email', $settings['email'] ?? '') }}" id="email" type="email"
                    placeholder="Email" name="email" required>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Tax Code</span>
                <span class="flex-[20px] font-semibold">:</span>
                <input
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('tax_code', e.target.value)"
                    value="{{ old('tax_code', $settings['tax_code'] ?? '') }}" id="tax_code" type="text"
                    placeholder="Tax Code" name="tax_code" required>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Phone</span>
                <span class="flex-[20px] font-semibold">:</span>
                <input
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('phone', e.target.value)"
                    value="{{ old('phone', $settings['phone'] ?? '') }}" id="phone" type="text"
                    placeholder="Phone" name="phone" required>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">REST User</span>
                <span class="flex-[20px] font-semibold">:</span>
                <input
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
                    onChange="(e) => setData('rest_api_user', e.target.value)"
                    value="{{ old('rest_api_user', $settings['rest_api_user'] ?? '') }}" id="rest_api_user"
                    type="text" name="rest_api_user" placeholder="Rest API User" required>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Business Type</span>
                <span class="flex-[20px] font-semibold">:</span>
                <select
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
                    id="business_type" name="business_type" disabled required>
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
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Product Stock Display</span>
                <span class="flex-[20px] font-semibold">:</span>
                <select
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
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
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Registration Process</span>
                <span class="flex-[20px] font-semibold">:</span>
                <select
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
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
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Offer Display</span>
                <span class="flex-[20px] font-semibold">:</span>
                <select
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
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
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Decimal Places</span>
                <span class="flex-[20px] font-semibold">:</span>
                <input
                    class="shadow appearance-none border rounded flex-[500px] py-2 text-gray-700 disabled:text-gray-400 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('decimal_places', $settings['decimal_places'] ?? '') }}" id="decimal_places"
                    type="number" name="decimal_places" placeholder="Decimal Places" min="0" max="5"
                    required>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>

        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Price with VAT</span>
                <span class="flex-[20px] font-semibold">:</span>
                <div class="flex-[500px]">
                    <input type="checkbox" class="mr-2 leading-tight"
                        {{ isset($settings['price_with_vat']) && $settings['price_with_vat'] ? 'checked' : '' }}
                        name="price_with_vat" id="price_with_vat" value="1" />
                </div>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Size and Color Options</span>
                <span class="flex-[20px] font-semibold">:</span>
                <div class="flex-[500px]">
                    <input type="checkbox" class="mr-2 leading-tight"
                        {{ isset($settings['size_color_options']) && $settings['size_color_options'] ? 'checked' : '' }}
                        name="size_color_options" id="size_color_options" value="1" />
                </div>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>

        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Accepted Payments</span>
                <span class="flex-[20px] font-semibold">:</span>
                <div class="flex-[500px]">
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
                        <input type="checkbox" class="mr-2 leading-tight" value="Collection and Payment on Site"
                            {{ in_array('Collection and Payment on Site', $settings['accepted_payments'] ?? []) ? 'checked' : '' }}
                            name="accepted_payments[]" id="collection_and_payment_on_site" />
                        <label class="text-sm" for="collection_and_payment_on_site">Collection and payment on
                            site</label>
                    </div>
                    {{-- <p>error</p> --}}
                    @if ($errors->has('accepted_payments'))
                        <span class="text-red-500">{{ $errors->first('accepted_payments') }}</span>
                    @endif
                </div>
            </div>
            {{-- <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div> --}}
        </div>
    </form>
</div>
