@section('title', 'Politica sulla privacy e sui cookie')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Politica sulla privacy e sui cookie']">
        <div id="editor">
            {!! isset($privacy_and_cookie) ? $privacy_and_cookie : '' !!}
        </div>
    </x-page-layout>
</x-app-guest-layout>
<script>
    // Assuming Quill is already initialized as per your previous setup
    const quill = new Quill('#editor', {
        placeholder: '',
        theme: 'bubble',
    });
    quill.enable(false);
</script>
