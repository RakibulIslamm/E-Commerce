@section('title', 'Crea Promozione')
<x-app-layout>
    @include('app.components.dashboard.promotion.promo-form')
</x-app-layout>

<script>
    document.getElementById('upload-promo-bg-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('promo-image-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
