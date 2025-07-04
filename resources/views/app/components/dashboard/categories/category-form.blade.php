    @if ($errors->has('error'))
    <div class="bg-red-100 text-red-700 border-l-4 border-red-500 p-4 mb-4">
        <strong>{{ $errors->first('error') }}</strong>
    </div>
    @endif

    <form method="post" action="{{ route('app.dashboard.categories.store') }}" enctype="multipart/form-data"
        class="p-6 bg-white rounded-lg">
        @csrf
        <div class="w-full flex items-center gap-3">
            <div class="w-full">
                <label for="codice" class="block text-gray-700 text-sm font-bold mb-2">Codice</label>
                <input id="codice" name="codice" type="text" value="{{ old('codice') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <x-input-error :messages="$errors->get('codice')" class="mt-2" />
            </div>
            <div class="w-full">
                <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                <input id="nome" name="nome" type="text" value="{{ old('nome') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <x-input-error :messages="$errors->get('nome')" class="mt-2" />
            </div>
        </div>

        <div class="mb-6">
            <div class="w-full mt-3">
                <label for="create-category-image-input"
                    class="px-5 py-2 border rounded-md flex items-center justify-start gap-2 w-max hover:bg-slate-100 cursor-pointer">
                    <x-lucide-image-up class="w-5 h-5" />
                    {{ __('Carica immagine') }}
                    <input accept="image/*" class="sr-only" type="file" name="img"
                        id="create-category-image-input">
                </label>
                <x-input-error :messages="$errors->get('img')" class="mt-2" />
                <p class="my-1 text-sm text-gray-600 font-bold">Cambia immagine Dimensioni obbligatorie: 500 X100px Attenzione, la scritta deve essere larga max 225 px e centrata all'interno dell'immagine.</p>
                <img id="create-category-image-preview" src="" class="mt-3 w-1/2 object-cover object-center"
                    alt="">
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <a href="{{ route('app.dashboard.categories') }}">
                Annulla
            </a>

            <x-primary-button class="ms-3" type="submit">
                {{ __('Creare') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('create-category-image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('create-category-image-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
