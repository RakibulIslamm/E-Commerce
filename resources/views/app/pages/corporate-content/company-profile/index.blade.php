@section('title', 'Profilo aziendale')
<x-app-layout>
    <div class="relative w-full max-w-full flex-grow flex-1 text-right">
        <a href="{{ route('app.corporate-content.company-profile.edit') }}"
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
            Modifica profilo aziendale
        </a>
    </div>
    <div id="editor" class="p-5 border rounded-lg mt-3 bg-white">
        {!! isset($about_us) ? $about_us : '' !!}
    </div>
</x-app-layout>

<script>
    // Assuming Quill is already initialized as per your previous setup
    const quill = new Quill('#editor', {
        placeholder: '',
        theme: 'bubble',
    });
    quill.enable(false);
</script>
