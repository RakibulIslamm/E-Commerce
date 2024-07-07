<form
    action="{{ $mode == 'edit' ? route('app.dashboard.articles.update', $article) : route('app.dashboard.articles.store') }}"
    id="article-submit" method="POST" class="w-full flex items-start gap-3" enctype="multipart/form-data">
    @csrf
    {{-- {{ old('name', $article['name'] ?? '') }} --}}
    @method($mode == 'edit' ? 'PUT' : 'POST')
    <div class="flex-1 w-full">
        <input type="text" name="title" value="{{ old('title', $article['title'] ?? '') }}"
            class="px-5 py-2 outline-none focus:ring-0 bg-transparent text-3xl font-bold text-gray-700 border-0 w-full"
            placeholder="Title...">
        <x-input-error :messages="$errors->get('title')" class="my-2" />
        <div class="w-full flex-1">
            <div id="editor" class="h-[400px] overflow-hidden overflow-y-auto">
                {!! old('body', $article['body'] ?? '') !!}
            </div>
        </div>
        <x-input-error :messages="$errors->get('body')" class="mt-2" />
    </div>
    <div class="border w-[300px] p-2 space-y-4 rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <p>Published</p>
                <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" class="peer sr-only" name="published"
                        {{ isset($article['published']) && $article['published'] ? 'checked' : '' }} />
                    <div
                        class="peer h-4 w-11 rounded border bg-slate-200 after:absolute after:-top-1 after:left-0 after:h-6 after:w-6 after:rounded-md after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-300 peer-checked:after:translate-x-full peer-focus:ring-green-300">
                    </div>
                </label>
            </div>
            @if ($mode == 'create')
                <button
                    class="px-5 py-1 rounded-md cursor-pointer flex items-center justify-start gap-2 w-max bg-blue-600 text-white"
                    type="submit">Add New</button>
            @elseif($mode == 'edit')
                <button
                    class="px-5 py-1 rounded-md cursor-pointer flex items-center justify-start gap-2 w-max bg-blue-600 text-white"
                    type="submit">Update</button>
            @endif
        </div>
        <div>
            <label for="">Publication Date</label>
            <input type="date" value="{{ old('publication_date', $article['publication_date'] ?? '') }}"
                name="publication_date" class="w-full rounded py-1">
            <x-input-error :messages="$errors->get('publication_date')" class="mt-2" />
        </div>
        <div class="my-1 w-full h-[1px] bg-gray-300"></div>
        <div class="space-y-2">
            <div>
                <label for="">Start Date</label>
                <input type="date" value="{{ old('start_date', $article['start_date'] ?? '') }}" name="start_date"
                    class="w-full rounded py-1">
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>
            <div>
                <label for="">End Date</label>
                <input type="date" value="{{ old('end_date', $article['end_date'] ?? '') }}" name="end_date"
                    class="w-full rounded py-1">
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
            </div>
        </div>
        <div class="w-full mt-3">
            <label id="article-img-input"
                class="px-5 py-1 border rounded-md cursor-pointer flex items-center justify-start gap-2 w-max">
                <x-lucide-image-up class="w-4 h-4" />
                Upload Image
                <input accept="image/*" class="sr-only" type="file" name="cover_img" id="article-img-input">
            </label>
            <x-input-error :messages="$errors->get('cover_img')" class="mt-2" />
            <img id="article-image-preview" src="{{ old('cover_img', tenant_asset($article['cover_img'] ?? '')) }}"
                class="mt-3 w-full object-cover object-center" alt="">
        </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('article-img-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('article-image-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
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
        document.getElementById('article-submit').addEventListener('submit', function(e) {
            // Get HTML content from Quill editor
            let editorHtml = quill.root.innerHTML;

            // Create a hidden input field to store the HTML content
            let hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name',
                'body'); // Assuming 'editorHtml' is the field name in your Laravel controller
            hiddenInput.setAttribute('value', editorHtml);

            // Append the hidden input field to the form
            this.appendChild(hiddenInput);
        });
    });
</script>
