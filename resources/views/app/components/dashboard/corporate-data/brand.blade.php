<?php

$logo_height = 56;
$logo = '/images/logo.png';
$name = null;
$description = null;
$tagline = null;
$favicon = null;

// dd($site_settings);

if (isset($site_settings->brand_info)) {
    $brand_info = $site_settings->brand_info;

    // Check if the keys exist before accessing them
    $logo_height = isset($brand_info['logo_height']) ? $brand_info['logo_height'] : '56';
    $logo = isset($brand_info['logo']) ? $brand_info['logo'] : '/images/logo.png';
    $name = isset($brand_info['name']) ? $brand_info['name'] : null;
    $description = isset($brand_info['description']) ? $brand_info['description'] : null;
    $tagline = isset($brand_info['tagline']) ? $brand_info['tagline'] : null;

    $favicon = isset($site_settings->brand_info['favicon']) ? asset($site_settings->brand_info['favicon']) : url('/images/favicon.png');
}

?>

<div class="w-full">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class=" italic text-sm text-red-600 font-semibold">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="logo" class="w-full flex items-center justify-between gap-2 p-5 bg-white rounded-lg shadow border">
        <div class=" space-y-2">
            <img class="w-auto" style="height: {{ $logo_height }}px" src="{{ $logo }}" alt="">
            <div>
                <h3 class="text-xl font-bold text-gray-700">{{ $name ?? 'Company Name' }}</h3>
                {{-- <div class="flex items-center gap-2">
                    <input type="checkbox" name="" id="brand_name_show">
                    <label for="brand_name_show" class="text-sm">Mostra il nome dell'azienda sulla barra di navigazione</label>
                </div> --}}
            </div>
        </div>
        <button id="edit-logo" class="px-5 py-1 border rounded">Edit</button>
    </div>
    <form method="POST" action="{{ route('app.corporate-data.update-brand') }}" id="logo-edit"
        enctype="multipart/form-data" class="w-full hidden flex-col gap-2 p-5 bg-white rounded-lg shadow border">
        @method('PUT')
        @csrf
        <div class="space-y-3">
            <div class="flex items-start gap-4">

                <div class="w-5/12">
                    <div class="w-full border relative group/logo">
                        <img id="logo-preview" class="w-full h-full border" src="{{ $logo }}" alt="">
                        <label id="upload-logo"
                            class="w-full h-full absolute top-0 left-0 bg-black bg-opacity-50 flex justify-center items-center invisible group-hover/logo:visible cursor-pointer">
                            <x-lucide-image-plus class="w-8 h-8 text-white" />
                            <input accept="image/*" class="sr-only" type="file" name="logo" id="upload-logo-input"
                                value="{{ $logo }}">
                        </label>
                    </div>
                    <button type="button"
                        class="w-full px-5 py-1 border rounded bg-sky-600 text-white disabled:bg-sky-300 mt-2"
                        onclick="document.getElementById('upload-logo-input').click()">scelto</button>

                    <div class="mt-2 flex items-center gap-2 group/fav cursor-pointer">
                        <h3 class="">Favicon:</h3>
                        <div class="w-8 h-8 relative group/favicon">
                            <img id="favicon-preview" class="w-full h-full border rounded-full" src="{{ $favicon }}" alt="">
                            <label for="upload-favicon-input" class="absolute top-0 left-0 w-full h-full bg-slate-900 bg-opacity-50 rounded-full flex justify-center items-center invisible group-hover/favicon:visible cursor-pointer">
                                <x-heroicon-o-plus class="w-6 h-6 text-white" />
                                <input accept="image/*" class="sr-only" type="file" name="favicon" id="upload-favicon-input">
                            </label>
                        </div>
                    </div>
                </div>


                <div class="space-y-2 w-7/12">
                    <div>
                        <label for="">Logo height</label>
                        <input name="logo_height" type="text" value="{{ $logo_height ?? '' }}"
                            placeholder="Logo Height"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="">Company Name</label>
                        <input name="name" type="text" value="{{ $name ?? '' }}" placeholder="Company Name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="">Tagline</label>
                        <input name="tagline" type="text" value="{{ $tagline ?? '' }}" placeholder="Company Tagline"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="w-full">
                        <label for="">Company Description</label>
                        <textarea name="description" placeholder="Company Description"
                            class="shadow appearance-none border rounded w-full h-[105px] py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $description ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            {{-- value="{{ old('company_name', $settings->domain ?? '') }}" --}}

        </div>
        <div class="ml-auto">
            <button type="button" id="cancel-logo-edit"
                class="px-5 py-1 border rounded bg-red-500 text-white">Cancel</button>
            <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Update</button>
        </div>
    </form>
</div>
<script type="module">
    commonUtils.element('edit-logo').addEventListener('click', () => {
        commonUtils.toggleVisibility('logo-edit', 'logo', 'flex');
    });

    commonUtils.element('cancel-logo-edit').addEventListener('click', () => {
        commonUtils.toggleVisibility('logo', 'logo-edit', 'flex');
    });


    setupFilePreview('upload-logo-input', 'logo-preview');
    setupFilePreview('upload-favicon-input', 'favicon-preview');


    function setupFilePreview(inputId, previewId) {
        document.getElementById(inputId).addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
