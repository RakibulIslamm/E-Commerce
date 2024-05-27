    <div class="px-20 py-10">
        @include('app.components.products.Partials.header')

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @include('app.components.products.Partials.product-item')
            @include('app.components.products.Partials.product-item')
            @include('app.components.products.Partials.product-item')
            @include('app.components.products.Partials.product-item')
        </div>
    </div>
