<x-modal name="add-product-photo-{{ $product['id'] }}" focusable>
    <form method="POST" class="p-6" action="{{ route('app.dashboard.product.upload', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-medium text-gray-900">{{ $product['DESCRIZIONEBREVE'] }}</h2>

        <div class="my-6"
             x-data="{
                 existingImages: @js($product['FOTO']),
                 newImages: [],
                 deleteImage(imagePath, index) {
                     if (confirm('Sei sicuro di voler eliminare questa immagine?')) {
                         fetch(`{{ route('app.dashboard.product.delete-product-image', $product['id'] ) }}`, {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                             },
                             body: JSON.stringify({ image_path: imagePath })
                         }).then(res => {
                             if (res.ok) this.existingImages.splice(index, 1);
                             else alert('Errore durante l\'eliminazione.');
                         });
                     }
                 },
                 handleNewImages(files) {
                     for (const file of files) {
                         const reader = new FileReader();
                         reader.onload = e => {
                             this.newImages.push({ file, src: e.target.result });
                         };
                         reader.readAsDataURL(file);
                     }
                 },
                 removeNewImage(index) {
                     this.newImages.splice(index, 1);
                 }
             }">

            {{-- Upload New Images --}}
            <div class="w-full mt-3">
                <label for="category-image-input-{{ $product['id'] }}"
                       class="px-5 py-2 border rounded-md flex items-center justify-start gap-2 w-max hover:bg-slate-100 cursor-pointer">
                    <x-lucide-image-up class="w-5 h-5" />
                    {{ __('Upload Images') }}
                    <input multiple accept="image/*" class="sr-only"
                           type="file" name="FOTO[]" id="category-image-input-{{ $product['id'] }}"
                           @change="handleNewImages($event.target.files)">
                </label>
                <x-input-error :messages="$errors->get('images')" class="mt-2" />
            </div>

            {{-- Existing Image Previews --}}
            <div class="mt-4">
                <p class="font-semibold text-gray-700 mb-2">Immagini esistenti:</p>
                <div class="flex flex-wrap gap-4">
                    <template x-for="(img, index) in existingImages" :key="index">
                        <div class="relative group w-48 h-32 border rounded overflow-hidden">
                            <img :src="'{{ asset('/') }}' + img" class="w-full h-full object-cover" />
                            <button type="button" @click="deleteImage(img, index)"
                                    class="absolute top-1 right-1 bg-red-600 p-1 rounded-full text-white opacity-90 hover:opacity-100">
                                <x-lucide-trash class="w-4 h-4" />
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- New Image Previews --}}
            <div class="mt-4">
                <p class="font-semibold text-gray-700 mb-2">Nuove immagini:</p>
                <div class="flex flex-wrap gap-4">
                    <template x-for="(img, index) in newImages" :key="index">
                        <div class="relative group w-48 h-32 border rounded overflow-hidden">
                            <img :src="img.src" class="w-full h-full object-cover" />
                            <button type="button" @click="removeNewImage(index)"
                                    class="absolute top-1 right-1 bg-red-600 p-1 rounded-full text-white opacity-90 hover:opacity-100">
                                <x-lucide-trash class="w-4 h-4" />
                            </button>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        {{-- Submit Buttons --}}
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancellare') }}</x-secondary-button>
            <x-primary-button class="ms-3">{{ __('Aggiornamento') }}</x-primary-button>
        </div>
    </form>
</x-modal>
