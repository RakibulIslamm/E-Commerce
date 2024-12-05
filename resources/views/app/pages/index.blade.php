@section('title', 'Home')
<x-app-guest-layout>
    @include('app.components.Home.banner.banner')
    @include('app.components.Home.categoris.index')
    @include('app.components.Home.new-arrivals.new-arrivals')
    @include('app.components.Home.promotion.promotion')
    @include('app.components.Home.products.index')
    @include('app.components.Home.blogs.index')
</x-app-guest-layout>
