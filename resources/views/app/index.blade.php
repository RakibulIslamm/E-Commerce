@section('title', 'Home')
<x-app-guest-layout>
    @include('app.components.banner.banner')
    @include('app.components.categoris.index')
    @include('app.components.products.index')
    @include('app.components.blogs.index')
    @include('app.components.contact.index')
    <div class="px-20 py-5">
        Footer Section
    </div>
</x-app-guest-layout>
