<form method="POST"
    action="{{ $mode == 'create' ? route('app.promotions.store') : route('app.promotions.update', $promotion) }}"
    id="logo-edit" enctype="multipart/form-data"
    class="w-full flex flex-col justify-start items-start gap-2 p-5 bg-white rounded-lg shadow border">
    @method($mode == 'edit' ? 'PUT' : 'POST')
    @csrf

    <div class="w-full flex items-center gap-3">
        <div class="w-full">
            <label for="slide_name" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
            <input id="slide_name" name="name" type="text" value="{{ old('name', $promotion['name'] ?? '') }}"
                required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>



        <div class="w-full">
            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Codice promozionale</label>
            <input id="code" name="code" type="text" value="{{ old('code', $promotion['code'] ?? '') }}"
                required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
    </div>
    <div class="w-full flex items-center gap-3">
        <div class="w-full mt-4">
            <label for="discount_amount" class="block text-gray-700 text-sm font-bold mb-2">Sconto</label>
            <input id="discount_amount" name="discount_amount" type="number" step="0.01" min="0"
                value="{{ old('discount_amount', $promotion['discount_amount'] ?? '') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('discount_amount')" class="mt-2" />
        </div>

        <div class="w-full mt-4">
            <label for="discount_percentage" class="block text-gray-700 text-sm font-bold mb-2">Percentuale sconto</label>
            <input id="discount_percentage" name="discount_percentage" type="number" min="0" max="100"
                value="{{ old('discount_percentage', $promotion['discount_percentage'] ?? '') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('discount_percentage')" class="mt-2" />
        </div>

        <div class="w-full mt-4">
            <label for="minimum_spend" class="block text-gray-700 text-sm font-bold mb-2">Spesa minima</label>
            <input id="minimum_spend" name="minimum_spend" type="number" step="0.01" min="0"
                value="{{ old('minimum_spend', $promotion['minimum_spend'] ?? '') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('minimum_spend')" class="mt-2" />
        </div>
    </div>

    <div class="w-full flex items-center gap-3">
        <div class="w-full mt-4">
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Data inizio</label>
            <input id="start_date" name="start_date" type="date"
                value="{{ old('start_date', $promotion['start_date'] ?? null) }}" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
        </div>

        <div class="w-full mt-4">
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Data fine</label>
            <input id="end_date" name="end_date" type="date"
                value="{{ old('end_date', $promotion['end_date'] ?? '') }}" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
        </div>
    </div>

    <div class="w-full mt-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descrizione</label>
        <textarea id="description" name="description"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            rows="3">{{ old('description', $promotion['description'] ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    <div>
        <input type="checkbox" class="mr-2 leading-tight"
        @checked(isset($promotion['active']) && $promotion['active']) name="active" id="active" />
        <label class="text-sm" for="active">Attiva la promozione</label>
    </div>

    <div class="w-full mt-3">
        <label id="upload-promo-bg-input"
            class="px-5 py-2 border rounded-md cursor-pointer flex items-center justify-start gap-2 w-max">
            <x-lucide-image-up class="w-5 h-5" />
            Carica immagine di sfondo
            <input accept="image/*" class="sr-only" type="file" name="bg_image" id="upload-slide-input">
        </label>
        <span class="text-sm text-red-800 block mt-2">Dimensioni dell'immagine 1920x1080</span>
        <img id="promo-image-preview" src="{{ $promotion['bg_image'] ?? '' }}"
            class="mt-3 w-full object-cover object-center" alt="">
    </div>

    <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Crea</button>
</form>


<script>
    const discountAmount = document.getElementById('discount_amount')
    const discountPercentage = document.getElementById('discount_percentage')

    discountAmount.addEventListener('change', () => {
        discountPercentage.value = '';
    })

    discountPercentage.addEventListener('change', () => {
        discountAmount.value = '';
    })
</script>
