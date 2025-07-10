<x-modal name="add-category-photo-{{ $category['id'] }}" focusable>
    <form method="post" class="p-6" action="{{ route('app.dashboard.categories.update', $category) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-medium text-gray-900">
            'Aggiornamento {{ $category['nome'] }} immagine della categoria
        </h2>

        <p class="mt-1 text-sm text-gray-600 font-bold">Cambia immagine Dimensioni obbligatorie: 500 X100px Attenzione, la scritta deve essere larga max 225 px e centrata all'interno dell'immagine.</p>

        <div class="my-6">
            <div class="w-full mt-3">
                <label for="category-image-input-{{ $category->id }}"
                    class="px-5 py-2 border rounded-md flex items-center justify-start gap-2 w-max hover:bg-slate-100 cursor-pointer">
                    <x-lucide-image-up class="w-5 h-5" />
                    {{ __('Carica immagine') }}
                    <input onchange="categoryImgPreview('{{ $category->id }}')" accept="image/*" class="sr-only"
                        type="file" name="img" id="category-image-input-{{ $category->id }}">
                </label>
                <x-input-error :messages="$errors->get('img')" class="mt-2" />
                <img id="category-image-preview-{{ $category->id }}"
                    src="{{ $category['img'] ? tenant_asset($category['img']) : '' }}"
                    class="mt-3 w-1/2 object-cover object-center" alt="">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Annulla') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Aggiornamento') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

<script>
    function categoryImgPreview(id) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('category-image-preview-' + id).src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>
