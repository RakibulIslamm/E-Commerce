@section('title', 'Add Products')
<x-app-layout>
    <div>
        @if (session()->has('error'))
            <p class="text-red-600 font-semibold py-5">{{ session('error') }}</p>
        @endif
        <form action="{{ route('app.dashboard.product.store') }}" method="POST" enctype="multipart/form-data"
            id="product-form" class=" space-y-3">
            @csrf

            <div class="mb-4">
                {{-- <label for="DESCRIZIONEBREVE" class="block text-gray-700">DESCRIZIONEBREVE</label> --}}
                <input type="text" name="DESCRIZIONEBREVE" id="DESCRIZIONEBREVE" value="{{ old('DESCRIZIONEBREVE') }}"
                    class="px-5 py-2 outline-none focus:ring-0 bg-transparent text-3xl font-bold text-gray-700 border-0 w-full"
                    required placeholder="Product Title">
                <x-input-error :messages="$errors->get('DESCRIZIONEBREVE')" class="my-2" />
            </div>

            <div class="w-full">
                {{-- <label for="DESCRIZIONEESTESA" class="block text-gray-700">DESCRIZIONEESTESA</label> --}}
                <div id="editor" class="h-[400px] overflow-hidden overflow-y-auto bg-white">
                    {!! old('DESCRIZIONEESTESA') !!}
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
                <div id="image-preview" class="flex flex-wrap gap-2 mt-3"></div>
            </div>

            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="BARCODE" class="block text-gray-700">BARCODE</label>
                    <input type="text" name="BARCODE" id="BARCODE" value="{{ old('BARCODE') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('BARCODE')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="ALIQUOTAIVA" class="block text-gray-700">ALIQUOTAIVA </label>
                    <input type="number" name="ALIQUOTAIVA" id="ALIQUOTAIVA" value="{{ old('ALIQUOTAIVA') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                    <x-input-error :messages="$errors->get('ALIQUOTAIVA')" class="my-2" />
                </div>
            </div>

            <div class="flex items-start gap-5 w-full">
                <div class="w-3/12">
                    <label for="UNITAMISURA" class="block text-gray-700">UNITAMISURA</label>
                    <input type="text" name="UNITAMISURA" id="UNITAMISURA" value="{{ old('UNITAMISURA', 'PZ') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('UNITAMISURA')" class="my-2" />
                </div>

                <div class="w-3/12">
                    <label for="PXC" class="block text-gray-700">PXC</label>
                    <input type="number" name="PXC" id="PXC" value="{{ old('PXC', 1) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('PXC')" class="my-2" />
                </div>

                <div class="w-6/12">
                    <label for="CODICELEGAME" class="block text-gray-700">CODICELEGAME</label>
                    <input type="text" name="CODICELEGAME" id="CODICELEGAME" value="{{ old('CODICELEGAME') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('CODICELEGAME')" class="my-2" />
                </div>
            </div>

            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="MARCA" class="block text-gray-700">MARCA</label>
                    <input type="text" name="MARCA" id="MARCA" value="{{ old('MARCA') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('MARCA')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="CATEGORIEESOTTOCATEGORIE" class="block text-gray-700">CATEGORIEESOTTOCATEGORIE</label>
                    <select name="CATEGORIEESOTTOCATEGORIE" id="CATEGORIEESOTTOCATEGORIE"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('CATEGORIEESOTTOCATEGORIE') == $category->nome ? 'selected' : '' }}>
                                {{ $category->codice . ' ' . strtoupper($category->nome) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('CATEGORIEESOTTOCATEGORIE')" class="my-2" />
                </div>
            </div>



            {{-- <div class="mb-4">
                <label for="ARTICOLIALTERNATIVI" class="block text-gray-700">ARTICOLIALTERNATIVI</label>
                <input type="text" name="ARTICOLIALTERNATIVI" id="ARTICOLIALTERNATIVI"
                    value="{{ old('ARTICOLIALTERNATIVI') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('ARTICOLIALTERNATIVI')" class="my-2" />
            </div>

            <div class="mb-4">
                <label for="ARTICOLICORRELATI" class="block text-gray-700">ARTICOLICORRELATI</label>
                <input type="text" name="ARTICOLICORRELATI" id="ARTICOLICORRELATI"
                    value="{{ old('ARTICOLICORRELATI') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('ARTICOLICORRELATI')" class="my-2" />
            </div> --}}

            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="GIACENZA" class="block text-gray-700">GIACENZA</label>
                    <input type="number" name="GIACENZA" id="GIACENZA" value="{{ old('GIACENZA', 0) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('GIACENZA')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="COLORE" class="block text-gray-700">COLORE</label>
                    <input type="text" name="COLORE" id="COLORE" value="{{ old('COLORE') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('COLORE')" class="my-2" />
                </div>
            </div>

            <div class="flex items-start gap-5 w-full">

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="NOVITA" id="NOVITA" value="1"
                        {{ old('NOVITA') ? 'checked' : '' }}>
                    <label for="NOVITA" class="block text-gray-700">NOVITA</label>
                    <x-input-error :messages="$errors->get('NOVITA')" class="my-2" />
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="PIUVENDUTI" id="PIUVENDUTI" value="1"
                        {{ old('PIUVENDUTI') ? 'checked' : '' }}">
                    <label for="PIUVENDUTI" class="block text-gray-700">PIUVENDUTI</label>
                    <x-input-error :messages="$errors->get('PIUVENDUTI')" class="my-2" />
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="VISIBILE" id="VISIBILE" value="1"
                        {{ old('VISIBILE', true) ? 'checked' : '' }}>
                    <label for="VISIBILE" class="block text-gray-700">VISIBILE</label>
                    <x-input-error :messages="$errors->get('VISIBILE')" class="my-2" />
                </div>
            </div>

            <div class="mb-4">
                <label for="TAGLIA" class="block text-gray-700">TAGLIA</label>
                <input type="text" name="TAGLIA" id="TAGLIA" value="{{ old('TAGLIA') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('TAGLIA')" class="my-2" />
            </div>

            <div class="mb-4">
                <label for="PESOARTICOLO" class="block text-gray-700">PESOARTICOLO</label>
                <input type="number" name="PESOARTICOLO" id="PESOARTICOLO" value="{{ old('PESOARTICOLO') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.001">
                <x-input-error :messages="$errors->get('PESOARTICOLO')" class="my-2" />
            </div>

            {{-- Price 1 --}}
            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="PRE1IMP" class="block text-gray-700">PRE1IMP</label>
                    <input type="number" name="PRE1IMP" id="PRE1IMP" value="{{ old('PRE1IMP') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                    <x-input-error :messages="$errors->get('PRE1IMP')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="PRE1IVA" class="block text-gray-700">PRE1IVA</label>
                    <input type="number" name="PRE1IVA" id="PRE1IVA" value="{{ old('PRE1IVA') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                    <x-input-error :messages="$errors->get('PRE1IVA')" class="my-2" />
                </div>
            </div>

            {{-- Price 2 --}}
            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="PRE2IMP" class="block text-gray-700">PRE2IMP</label>
                    <input type="number" name="PRE2IMP" id="PRE2IMP" value="{{ old('PRE2IMP') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                    <x-input-error :messages="$errors->get('PRE2IMP')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="PRE2IVA" class="block text-gray-700">PRE2IVA</label>
                    <input type="number" name="PRE2IVA" id="PRE2IVA" value="{{ old('PRE2IVA') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                    <x-input-error :messages="$errors->get('PRE2IVA')" class="my-2" />
                </div>
            </div>

            {{-- Price 3 --}}
            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="PRE3IMP" class="block text-gray-700">PRE3IMP</label>
                    <input type="number" name="PRE3IMP" id="PRE3IMP" value="{{ old('PRE3IMP') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                    <x-input-error :messages="$errors->get('PRE3IMP')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="PRE3IVA" class="block text-gray-700">PRE3IVA</label>
                    <input type="number" name="PRE3IVA" id="PRE3IVA" value="{{ old('PRE3IVA') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                    <x-input-error :messages="$errors->get('PRE3IVA')" class="my-2" />
                </div>
            </div>

            <div class="mb-4">
                <label for="PREPROMOIMP" class="block text-gray-700">PREPROMOIMP</label>
                <input type="number" name="PREPROMOIMP" id="PREPROMOIMP" value="{{ old('PREPROMOIMP') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PREPROMOIMP')" class="my-2" />
            </div>

            <div class="mb-4">
                <label for="PREPROMOIVA" class="block text-gray-700">PREPROMOIVA</label>
                <input type="number" name="PREPROMOIVA" id="PREPROMOIVA" value="{{ old('PREPROMOIVA') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" step="0.01">
                <x-input-error :messages="$errors->get('PREPROMOIVA')" class="my-2" />
            </div>

            <div class="flex items-start gap-5 w-full">
                <div class="w-full">
                    <label for="DATAINIZIOPROMO" class="block text-gray-700">DATAINIZIOPROMO</label>
                    <input type="date" name="DATAINIZIOPROMO" id="DATAINIZIOPROMO"
                        value="{{ old('DATAINIZIOPROMO') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('DATAINIZIOPROMO')" class="my-2" />
                </div>

                <div class="w-full">
                    <label for="DATAFINEPROMO" class="block text-gray-700">DATAFINEPROMO</label>
                    <input type="date" name="DATAFINEPROMO" id="DATAFINEPROMO"
                        value="{{ old('DATAFINEPROMO') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('DATAFINEPROMO')" class="my-2" />
                </div>
            </div>

            <div class="flex items-center justify-end ">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm my-4">Add
                    Product</button>
            </div>
        </form>
    </div>
</x-app-layout>

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