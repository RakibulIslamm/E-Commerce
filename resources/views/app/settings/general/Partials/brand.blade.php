<div class="w-full">
    <div id="logo" class="w-full flex items-center justify-between gap-2 p-5 bg-white rounded-lg shadow border">
        <div class="flex items-center gap-2">
            <img class="w-14 h-14" src="/images/logo.png" alt="">
            <h3 class="text-xl font-bold text-gray-700">Ecommerce</h3>
        </div>
        <button id="edit-logo" class="px-5 py-1 border rounded">Edit</button>
    </div>
    <div id="logo-edit" class="w-full hidden flex-col gap-2 p-5 bg-white rounded-lg shadow border">
        <div class="space-y-3">
            <div class="flex items-start gap-4">
                <div class="w-5/12">
                    <div class="w-full border relative group/logo">
                        <img class="w-full h-full border" src="/images/logo.png" alt="">
                        <label id="upload-logo"
                            class="w-full h-full absolute top-0 left-0 bg-black bg-opacity-50 flex justify-center items-center invisible group-hover/logo:visible cursor-pointer">
                            <x-lucide-image-plus class="w-8 h-8 text-white" />
                            <input class="sr-only" type="file" name="logo" id="upload-logo">
                        </label>
                    </div>
                    <button disabled
                        class="w-full px-5 py-1 border rounded bg-sky-600 text-white disabled:bg-sky-300 mt-2">Upload</button>
                    <button disabled
                        class="w-full px-5 py-1 border rounded bg-sky-600 text-white disabled:bg-sky-300 mt-2">Save</button>
                </div>


                <div class="space-y-2 w-7/12">
                    <div>
                        <label for="">Logo Width</label>
                        <input name="logo_height" type="text" value="20" placeholder="Company Name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="">Company Name</label>
                        <input name="company_name" type="text" value="Ecommerce" placeholder="Company Name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="">Tagline</label>
                        <input name="company_name" type="text" value="Tagline goes here" placeholder="Company Name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="w-full">
                        <label for="">Company Description</label>
                        <textarea name="company_desc" placeholder="Company Description"
                            class="shadow appearance-none border rounded w-full h-[105px] py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                </div>
            </div>
            {{-- value="{{ old('company_name', $settings->domain ?? '') }}" --}}

        </div>
        <div class="ml-auto">
            <button id="cancel-logo-edit" class="px-5 py-1 border rounded bg-red-500 text-white">Cancel</button>
            <button class="px-5 py-1 border rounded bg-sky-500 text-white">Update</button>
        </div>
    </div>
</div>
<script type="module">
    commonUtils.element('edit-logo').addEventListener('click', () => {
        commonUtils.toggleVisibility('logo-edit', 'logo', 'flex');
    });

    commonUtils.element('cancel-logo-edit').addEventListener('click', () => {
        commonUtils.toggleVisibility('logo', 'logo-edit', 'flex');
    });
</script>
