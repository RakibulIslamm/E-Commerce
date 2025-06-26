@section('title', 'Modifica condizione di vendita')
<x-app-layout>
    <form action="{{ route('app.corporate-content.condition-for-sale.update') }}" method="POST" id="company-profile-form">
        @csrf
        @method('PUT')
        <div id="editor">
            {!! isset($condition_for_sale) ? $condition_for_sale : '' !!}
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
            'condition_for_sale'); // Assuming 'editorHtml' is the field name in your Laravel controller
        hiddenInput.setAttribute('value', editorHtml);

        // Append the hidden input field to the form
        this.appendChild(hiddenInput);
    });
</script>
