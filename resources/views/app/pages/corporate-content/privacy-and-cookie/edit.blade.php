@section("title", "Modifica l'informativa sulla privacy e sui cookie")
<x-app-layout>
    <form action="{{ route('app.corporate-content.privacy-and-cookie.update') }}" method="POST" id="privacy-and-cookie-form">
        @csrf
        @method('PUT')
        <div id="editor">
            {!! isset($privacy_and_cookie) ? $privacy_and_cookie : '' !!}
        </div>
        <button
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-5 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 mt-2"
            type="submit">Save</button>
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
        placeholder: '',
        theme: 'snow', // or 'bubble'
    });

    const getData = () => {
        let editorHtml = quill.root.innerHTML;
        
    }

    // Intercept form submission
    document.getElementById('privacy-and-cookie-form').addEventListener('submit', function(e) {
        // Get HTML content from Quill editor
        let editorHtml = quill.root.innerHTML;

        // Create a hidden input field to store the HTML content
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name',
            'privacy_and_cookie');
        hiddenInput.setAttribute('value', editorHtml);

        // Append the hidden input field to the form
        this.appendChild(hiddenInput);
    });
</script>
