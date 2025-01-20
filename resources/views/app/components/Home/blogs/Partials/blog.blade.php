<article class="flex max-w-xl flex-col items-start justify-between p-4 border rounded-lg">
    <div class="flex items-center gap-x-4 text-xs">
        <time datetime="{{ $item->publication_date }}" class="text-gray-500">
            {{ \Carbon\Carbon::parse($item->publication_date)->format('M d, Y') }}
        </time>
        <a href="#"
            class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
            News
        </a>
    </div>
    <div class="group relative">
        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
            <a href="#">
                <span class="absolute inset-0"></span>
                {{ $item->title }}
            </a>
        </h3>
        <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
            {!! \Illuminate\Support\Str::limit(strip_tags($item->body), 120) !!}
        </p>
    </div>
    {{-- <div class="relative mt-8 flex items-center gap-x-4">
        <img src="{{ asset($item->cover_img) }}" 
             alt="{{ $item->title }}" 
             class="h-10 w-10 rounded-full bg-gray-50">
        <div class="text-sm leading-6">
            <p class="font-semibold text-gray-900">
                <a href="#">
                    <span class="absolute inset-0"></span>
                    Admin
                </a>
            </p>
            <p class="text-gray-600">Editor</p>
        </div>
    </div> --}}
</article>