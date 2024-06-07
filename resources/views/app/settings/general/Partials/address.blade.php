<div id="address" class="w-full p-5 bg-white rounded-lg shadow border mt-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold pb-2">Company Address</h2>
        <button id="edit-address" class="px-5 py-1 border rounded">Edit</button>
    </div>
    <p>address goes here</p>
</div>
<div id="address-edit" class="w-full hidden p-5 bg-white rounded-lg shadow mt-4 border">
    <h2 class="text-xl font-semibold pb-2">Edit Company Address</h2>
    <form class="w-full space-y-3">
        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-full">
                <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City</label>
                <input id="city" name="city" type="text"
                    value="{{ old('city', $settings->data->city ?? '') }}" required placeholder="Ex: Dhaka"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-full">
                <label for="state" class="block text-gray-700 text-sm font-bold mb-2">State</label>
                <input id="state" name="state" type="text"
                    value="{{ old('state', $settings->data->state ?? '') }}" placeholder="Ex: Dhaka"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-full">
                <label for="country" class="block text-gray-700 text-sm font-bold mb-2">Country</label>
                <input id="country" name="country" type="password"
                    value="{{ old('country', $settings->data->country ?? '') }}" placeholder="Ex: Bangladesh"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>
        <div class="w-full">
            <label for="street" class="block text-gray-700 text-sm font-bold mb-2">Street</label>
            <input id="street" name="street" type="text"
                value="{{ old('street', $settings->data->street ?? '') }}" required
                placeholder="Ex: 12/A Danmondi, Road 24, Dhaka"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex justify-end gap-2">
            <button type="button" id="cancel-edit-address"
                class="px-5 py-1 border rounded bg-red-500 text-white">Cancel</button>
            <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Update</button>
        </div>
    </form>
</div>

<script type="module">
    commonUtils.element('edit-address').addEventListener('click', () => {
        commonUtils.toggleVisibility('address-edit', 'address', 'block');
    });

    commonUtils.element('cancel-edit-address').addEventListener('click', () => {
        commonUtils.toggleVisibility('address', 'address-edit', 'block');
    });
</script>
