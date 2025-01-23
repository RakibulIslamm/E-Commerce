@section('title', $newsItem->title)
{{-- @dd($newsItem) --}}
<x-app-guest-layout>
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs ?? null, 'title' => $newsItem->title]">
        <article class="max-w-4xl mx-auto p-4 border rounded-lg">
            <div class="mb-6">
                <time datetime="{{ $newsItem->publication_date }}" class="text-sm text-gray-500">
                    Published on {{ \Carbon\Carbon::parse($newsItem->publication_date)->format('M d, Y') }}
                </time>
                <div class="mt-1">
                    <a href="#" class="inline-block bg-gray-50 text-gray-600 px-3 py-1.5 rounded-full font-medium hover:bg-gray-100">
                        News
                    </a>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $newsItem->title }}</h1>
            
            @if (!empty($newsItem->cover_img))
                <div class="mt-6 lg:h-[300px] h-[150px]">
                    <img src="{{ asset($newsItem->cover_img) }}" alt="{{ $newsItem->title }}" class="aspect-16/9 h-full object-cover rounded-lg">
                </div>
            @endif

            <div class="mt-6 text-gray-800 leading-relaxed space-y-6">
                {!! $newsItem->body !!}
            </div>

            <div class="mt-8 flex items-center gap-x-4">
                <img src="{{ tenant_asset($newsItem->author_img ?? 'default-author.png') }}" 
                     alt="{{ $newsItem->author_name }}" 
                     class="h-10 w-10 rounded-full bg-gray-50">
                <div>
                    <p class="text-sm font-semibold text-gray-900">
                        By {{ $newsItem->author_name ?? 'Admin' }}
                    </p>
                    <p class="text-sm text-gray-600">{{ $newsItem->author_role ?? 'Editor' }}</p>
                </div>
            </div>
        </article>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Related News</h2>
            <div class="grid lg:grid-cols-3 grid-cols-1 gap-8">
                @foreach ($relatedNews as $relatedItem)
                    @include('app.components.Home.blogs.Partials.blog', ['item' => $relatedItem])
                @endforeach
            </div>
        </section>
    </x-page-layout>
</x-app-guest-layout>
