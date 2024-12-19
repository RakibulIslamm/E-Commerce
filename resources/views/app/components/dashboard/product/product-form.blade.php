<form
    action="{{ $mode == 'edit' ? route('app.dashboard.product.update', $product) : route('app.dashboard.product.store') }}"
    method="POST" enctype="multipart/form-data" id="product-form">
    @method($mode == 'edit' ? 'PUT' : 'POST')
    @csrf
    @if (session()->has('error'))
        <p class="text-red-600 font-semibold py-3 px-5">{{ session('error') }}</p>
    @endif
    <div class="space-y-3">
        <div class="mb-4">
            <input type="text" name="DESCRIZIONEBREVE" id="DESCRIZIONEBREVE"
                value="{{ old('DESCRIZIONEBREVE', $product['DESCRIZIONEBREVE'] ?? '') }}"
                class="px-5 py-2 outline-none focus:ring-0 bg-transparent text-3xl font-bold text-gray-700 border-0 w-full"
                required placeholder="Product Title">
            <x-input-error :messages="$errors->get('DESCRIZIONEBREVE')" class="my-2" />
        </div>



        <div class="w-full">
            <div id="editor" class="h-[400px] overflow-hidden overflow-y-auto bg-white">
                {!! old('DESCRIZIONEESTESA', $product['DESCRIZIONEESTESA'] ?? '') !!}
            </div>
            <x-input-error :messages="$errors->get('DESCRIZIONEESTESA')" class="my-2" />
        </div>

        <div class="w-full my-3">
            <label id="foto-input"
                class="px-5 py-1 border border-gray-300 rounded-md cursor-pointer flex items-center justify-start gap-2 w-max">
                <x-lucide-image-up class="w-4 h-4" />
                Upload FOTO
                <input type="file" name="FOTO[]" id="FOTO" accept="image/*" multiple class="sr-only">
            </label>
            <x-input-error :messages="$errors->get('FOTO')" class="my-2" />
            <div id="image-preview" class="flex flex-wrap gap-2 mt-3">
                {{-- @dd($product['FOTO']) --}}
                @foreach (old('FOTO', $product['FOTO'] ?? []) as $img)
                    <img class="w-20 h-20 object-cover border rounded-md" src="{{ tenant_asset($img) }}"
                        alt="">
                @endforeach
            </div>
        </div>

        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="BARCODE" class="block text-gray-700">BARCODE</label>
                <input type="text" name="BARCODE" id="BARCODE"
                    value="{{ old('BARCODE', $product['BARCODE'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('BARCODE')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="ALIQUOTAIVA" class="block text-gray-700">ALIQUOTAIVA </label>
                <input type="number" name="ALIQUOTAIVA" id="ALIQUOTAIVA"
                    value="{{ old('ALIQUOTAIVA', $product['ALIQUOTAIVA'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                <x-input-error :messages="$errors->get('ALIQUOTAIVA')" class="my-2" />
            </div>
        </div>

        <div class="flex items-start gap-5 w-full">
            <div class="w-3/12">
                <label for="UNITAMISURA" class="block text-gray-700">UNITAMISURA</label>
                <input type="text" name="UNITAMISURA" id="UNITAMISURA"
                    value="{{ old('UNITAMISURA', 'PZ', $product['UNITAMISURA'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('UNITAMISURA')" class="my-2" />
            </div>

            <div class="w-3/12">
                <label for="PXC" class="block text-gray-700">PXC</label>
                <input type="number" name="PXC" id="PXC" value="{{ old('PXC', $product['PXC'] ?? 1) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('PXC')" class="my-2" />
            </div>

            <div class="w-6/12">
                <label for="CODICELEGAME" class="block text-gray-700">CODICELEGAME</label>
                <input type="text" name="CODICELEGAME" id="CODICELEGAME"
                    value="{{ old('CODICELEGAME', $product['CODICELEGAME'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('CODICELEGAME')" class="my-2" />
            </div>
        </div>

        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="MARCA" class="block text-gray-700">MARCA</label>
                <input type="text" name="MARCA" id="MARCA" value="{{ old('MARCA', $product['MARCA'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('MARCA')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="CATEGORIEESOTTOCATEGORIE" class="block text-gray-700">CATEGORIEESOTTOCATEGORIE</label>
                <select name="CATEGORIEESOTTOCATEGORIE" id="CATEGORIEESOTTOCATEGORIE"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="">Select a category</option>
                    @foreach ($categories_for_form as $category)
                        <option value="{{ $category->codice }}"
                            {{ old('CATEGORIEESOTTOCATEGORIE', $product['CATEGORIEESOTTOCATEGORIE'][0] ?? '') == $category->codice ? 'selected' : '' }}>
                            {{ $category->codice . ' ' . strtoupper($category->nome) }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('CATEGORIEESOTTOCATEGORIE')" class="my-2" />
            </div>
        </div>

        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="GIACENZA" class="block text-gray-700">GIACENZA</label>
                <input type="number" name="GIACENZA" id="GIACENZA"
                    value="{{ old('GIACENZA', $product['GIACENZA'] ?? 0) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('GIACENZA')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="COLORE" class="block text-gray-700">COLORE</label>
                <input type="text" name="COLORE" id="COLORE"
                    value="{{ old('COLORE', $product['COLORE'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('COLORE')" class="my-2" />
            </div>
        </div>

        <div class="flex items-start gap-5 w-full">

            <div class="flex items-center gap-2">
                <input type="checkbox" name="NOVITA" id="NOVITA" value="1"
                    {{ old('NOVITA', $product['NOVITA'] ?? ($product['DESCRIZIONEBREVE'] ?? true)) ? 'checked' : '' }}>
                <label for="NOVITA" class="block text-gray-700">NOVITA</label>
                <x-input-error :messages="$errors->get('NOVITA')" class="my-2" />
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="PIUVENDUTI" id="PIUVENDUTI" value="1"
                    {{ old('PIUVENDUTI', $product['PIUVENDUTI'] ?? false) ? 'checked' : '' }}>
                <label for="PIUVENDUTI" class="block text-gray-700">PIUVENDUTI</label>
                <x-input-error :messages="$errors->get('PIUVENDUTI')" class="my-2" />
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="VISIBILE" id="VISIBILE" value="1"
                    {{ old('VISIBILE', $product['VISIBILE'] ?? true) ? 'checked' : '' }}>
                <label for="VISIBILE" class="block text-gray-700">VISIBILE</label>
                <x-input-error :messages="$errors->get('VISIBILE')" class="my-2" />
            </div>
        </div>

        <div class="mb-4">
            <label for="TAGLIA" class="block text-gray-700">TAGLIA</label>
            <input type="text" name="TAGLIA" id="TAGLIA"
                value="{{ old('TAGLIA', $product['TAGLIA'] ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            <x-input-error :messages="$errors->get('TAGLIA')" class="my-2" />
        </div>

        <div class="mb-4">
            <label for="PESOARTICOLO" class="block text-gray-700">PESOARTICOLO</label>
            <input type="number" name="PESOARTICOLO" id="PESOARTICOLO"
                value="{{ old('PESOARTICOLO', $product['PESOARTICOLO'] ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.001">
            <x-input-error :messages="$errors->get('PESOARTICOLO')" class="my-2" />
        </div>

        {{-- Price 1 --}}
        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="PRE1IMP" class="block text-gray-700">PRE1IMP</label>
                <input type="number" name="PRE1IMP" id="PRE1IMP"
                    value="{{ old('PRE1IMP', $product['PRE1IMP'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PRE1IMP')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="PRE1IVA" class="block text-gray-700">PRE1IVA</label>
                <input type="number" name="PRE1IVA" id="PRE1IVA"
                    value="{{ old('PRE1IVA', $product['PRE1IVA'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PRE1IVA')" class="my-2" />
            </div>
        </div>

        {{-- Price 2 --}}
        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="PRE2IMP" class="block text-gray-700">PRE2IMP</label>
                <input type="number" name="PRE2IMP" id="PRE2IMP"
                    value="{{ old('PRE2IMP', $product['PRE2IMP'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PRE2IMP')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="PRE2IVA" class="block text-gray-700">PRE2IVA</label>
                <input type="number" name="PRE2IVA" id="PRE2IVA"
                    value="{{ old('PRE2IVA', $product['PRE2IVA'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PRE2IVA')" class="my-2" />
            </div>
        </div>

        {{-- Price 3 --}}
        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="PRE3IMP" class="block text-gray-700">PRE3IMP</label>
                <input type="number" name="PRE3IMP" id="PRE3IMP"
                    value="{{ old('PRE3IMP', $product['PRE3IMP'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PRE3IMP')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="PRE3IVA" class="block text-gray-700">PRE3IVA</label>
                <input type="number" name="PRE3IVA" id="PRE3IVA"
                    value="{{ old('PRE3IVA', $product['PRE3IVA'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PRE3IVA')" class="my-2" />
            </div>
        </div>

        <div class="mb-4">
            <label for="PREPROMOIMP" class="block text-gray-700">PREPROMOIMP</label>
            <input type="number" name="PREPROMOIMP" id="PREPROMOIMP"
                value="{{ old('PREPROMOIMP', $product['PREPROMOIMP'] ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
            <x-input-error :messages="$errors->get('PREPROMOIMP')" class="my-2" />
        </div>

        <div class="mb-4">
            <label for="PREPROMOIVA" class="block text-gray-700">PREPROMOIVA</label>
            <input type="number" name="PREPROMOIVA" id="PREPROMOIVA"
                value="{{ old('PREPROMOIVA', $product['PREPROMOIVA'] ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
            <x-input-error :messages="$errors->get('PREPROMOIVA')" class="my-2" />
        </div>

        <div class="flex items-start gap-5 w-full">
            <div class="w-full">
                <label for="DATAINIZIOPROMO" class="block text-gray-700">DATAINIZIOPROMO</label>
                <input type="date" name="DATAINIZIOPROMO" id="DATAINIZIOPROMO"
                    value="{{ old('DATAINIZIOPROMO', $product['DATAINIZIOPROMO'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('DATAINIZIOPROMO')" class="my-2" />
            </div>

            <div class="w-full">
                <label for="DATAFINEPROMO" class="block text-gray-700">DATAFINEPROMO</label>
                <input type="date" name="DATAFINEPROMO" id="DATAFINEPROMO"
                    value="{{ old('DATAFINEPROMO', $product['DATAFINEPROMO'] ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('DATAFINEPROMO')" class="my-2" />
            </div>
        </div>

        <div class="flex items-center justify-end ">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm my-4">{{ $mode == 'edit' ? 'Update' : 'Add Product' }}</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('FOTO').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = ''; // Clear previous previews

            Array.from(event.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-20', 'h-20', 'object-cover', 'border',
                            'rounded-md');
                        imagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        const quill = new Quill('#editor', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, 3, 4, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    ['blockquote', 'code-block'],
                    ['link'],
                    [{
                        'align': []
                    }],
                    //   ['image', 'code-block'],
                ],
            },
            placeholder: 'Compose an epic...',
            theme: 'snow', // or 'bubble'
        });

        // Intercept form submission
        document.getElementById('product-form').addEventListener('submit', function(e) {
            // Get HTML content from Quill editor
            let editorHtml = quill.root.innerHTML;

            // Create a hidden input field to store the HTML content
            let hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name',
                'DESCRIZIONEESTESA');
            hiddenInput.setAttribute('value', editorHtml);

            // Append the hidden input field to the form
            this.appendChild(hiddenInput);
        });
    });
</script>
