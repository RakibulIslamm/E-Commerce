@section('title', 'Modifica profilo aziendale')
<x-app-layout>
    <form action="{{ route('app.corporate-content.company-profile.update') }}" method="POST" id="company-profile-form">
        @csrf
        @method('PUT')
        <div id="editor">
            {!! isset($about_us) ? $about_us : '' !!}
        </div>
        <button
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-5 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 mt-2"
            type="submit">Aggiornamento</button>
    </form>
</x-app-layout>

<script>
    // Assuming Quill is already initialized as per your previous setup
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

    const getData = () => {
        let editorHtml = quill.root.innerHTML;
        console.log(editorHtml)
    }

    // Intercept form submission
    document.getElementById('company-profile-form').addEventListener('submit', function(e) {
        // Get HTML content from Quill editor
        let editorHtml = quill.root.innerHTML;

        // Create a hidden input field to store the HTML content
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name',
            'about_us'); // Assuming 'editorHtml' is the field name in your Laravel controller
        hiddenInput.setAttribute('value', editorHtml);

        // Append the hidden input field to the form
        this.appendChild(hiddenInput);
    });
</script>
