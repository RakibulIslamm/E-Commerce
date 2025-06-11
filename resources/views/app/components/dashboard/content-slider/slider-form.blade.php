<form method="POST"
    action="{{ $mode == 'create' ? route('app.dashboard.slider.store') : route('app.dashboard.slider.update', $slider) }}"
    id="logo-edit" enctype="multipart/form-data"
    class="w-full flex flex-col justify-start items-start gap-2 p-5 bg-white rounded-lg shadow border">
    @method($mode == 'edit' ? 'PUT' : 'POST')
    @csrf

    {{-- value="{{ old('business_name', $ecommerce->business_name ?? '') }}" --}}

    <div class="w-full flex items-center gap-3">
        <div class="w-full">
            <label for="slide_name" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
            <input id="slide_name" name="name" type="text" value="{{ old('name', $slider['name'] ?? '') }}"
                required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="w-full">
            <label for="slide_title" class="block text-gray-700 text-sm font-bold mb-2">Titolo</label>
            <input id="slide_title" name="title" type="text" value="{{ old('title', $slider['title'] ?? '') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>
    <div class="w-full flex items-center gap-3">
        <div class="w-full">
            <label for="slide_link" class="block text-gray-700 text-sm font-bold mb-2">Link</label>
            <input id="slide_link" name="link" type="text" value="{{ old('link', $slider['link'] ?? '') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="w-full">
            <label for="link_text" class="block text-gray-700 text-sm font-bold mb-2">Link Text</label>
            <input id="link_text" name="link_text" type="text"
                value="{{ old('link_text', $slider['link_text'] ?? '') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <div class="w-full">
        <label class="block text-gray-700 text-sm font-bold mb-2">Breve descrizione</label>
        <textarea name="description"
            class="shadow appearance-none border rounded w-full h-[105px] py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            maxlength="100">{{ old('description', $slider['description'] ?? '') }}</textarea>
        <span class="text-xs text-red-800 block -mt-2">Lunghezza massima 100 caratteri</span>
    </div>
    @if ($mode == 'edit')
        <div class="w-full">
            <label class="block text-gray-700 text-sm font-bold mb-2">Posizione</label>
            <input name="position" type="number" value="{{ old('position', $slider['position'] ?? '') }}"
                class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                maxlength="100">
        </div>
    @endif
    <div class="w-full mt-3">
        <label id="upload-slide-image"
            class="px-5 py-2 border rounded-md cursor-pointer flex items-center justify-start gap-2 w-max">
            <x-lucide-image-up class="w-5 h-5" />
            Carica immagine
            <input accept="image/*" class="sr-only" type="file" name="img" id="upload-slide-input">
        </label>
        <span class="text-sm text-red-800 block mt-2">Dimensione immagine 1920x500</span>
        <img id="slide-image-preview" src="{{ $slider['img'] ?? '' }}" class="mt-3 w-full object-cover object-center"
            alt="">
    </div>

    <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Creare</button>
</form>
