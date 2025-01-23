<div class="w-full lg:px-20 sm:px-10 px-5 lg:py-10 py-8">
    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our News</h2>
    <div class="mt-4 border-t pt-5 grid lg:grid-cols-3 grid-cols-1 gap-8">
        @if (!empty($news))
        @foreach ($news as $item)
            @include('app.components.Home.blogs.Partials.blog', ['item' => $item])
        @endforeach
        @endif
    </div>
</div>
