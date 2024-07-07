@section('title', 'Create New Slider')
<x-app-layout>

    <div>
        @include('app.components.dashboard.content-slider.slider-form')
    </div>


</x-app-layout>

<script>
    document.getElementById('upload-slide-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('slide-image-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
