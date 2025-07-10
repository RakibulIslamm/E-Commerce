@section('title', 'Condizioni di vendita')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Condition For Sale']">
        <div id="editor">
            {!! isset($condition_for_sale) ? $condition_for_sale : '' !!}
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
