@section('title', 'About us')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Profile']">
        <div id="editor">
            {!! isset($about_us) ? $about_us : '' !!}
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
