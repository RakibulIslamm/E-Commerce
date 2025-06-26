@section('title', 'Home')
<x-app-guest-layout>
    @include('app.components.Home.banner.banner')
    @include('app.components.Home.categoris.index')
    @if (!$newArrivals->isEmpty())
        @include('app.components.Home.new-arrivals.new-arrivals')
    @endif
    @include('app.components.Home.promotion.promotion')
    @if (!$bestSellers->isEmpty())
        @include('app.components.Home.products.index')
    @endif
    {{-- @include('app.components.Home.blogs.index') --}}
</x-app-guest-layout>
