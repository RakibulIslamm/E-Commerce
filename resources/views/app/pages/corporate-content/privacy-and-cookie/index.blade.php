@section('title', 'Politica sulla privacy e sui cookie')
<x-app-layout>
    <div class="relative w-full max-w-full flex-grow flex-1 text-right">
        <a href="{{ route('app.corporate-content.privacy-and-cookie.edit') }}"
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
            Edit
        </a>
    </div>
    <div id="editor" class="p-5 border rounded-lg mt-3 bg-white">
        {!! isset($privacy_and_cookie) ? $privacy_and_cookie : '' !!}
    </div>
</x-app-layout>

<script>
    // Assuming Quill is already initialized as per your previous setup
    const quill = new Quill('#editor', {
        placeholder: 'Compose an epic...',
        theme: 'bubble',
    });
    quill.enable(false);
</script>
