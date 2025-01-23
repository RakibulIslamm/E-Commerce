@section('title', 'News')
<x-app-guest-layout>
    <x-page-layout :props="['breadcrumbs' => $breadcrumbs, 'title' => 'News']">
        @if (!empty($news))
            <div class="grid lg:grid-cols-3 grid-cols-1 gap-8">
                @foreach ($news as $item)
                    @include('app.components.Home.blogs.Partials.blog', [
                        'item' => $item,
                    ])
                @endforeach
            </div>
            
            <div class="py-5 space-y-3">
                @if ($news->total() > 0)
                    <p>
                        Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }}
                        items
                    </p>
                @endif

                @if ($news->hasPages())
                    <ul class="flex items-center flex-wrap gap-3 m-0 p-0">
                        {{-- Previous Page Link --}}
                        @if ($news->onFirstPage())
                            <li class="py-1 px-3">
                                <x-ri-arrow-left-double-fill class="w-5 h-5 text-gray-400" />
                            </li>
                        @else
                            <li><a class="" href="{{ $news->appends(request()->all())->previousPageUrl() }}"
                                    rel="prev"><x-ri-arrow-left-double-fill class="w-5 h-5" /></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($news->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            {{-- @if (is_string($element))
                            <li class="disabled"><span>{{ $element }}</span></li>
                        @endif --}}

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $news->currentPage())
                                        <li class="text-gray-400 py-1 px-1"><span>{{ $page }}</span></li>
                                    @else
                                        <li class="text-gray-900"><a class="py-1 px-3 border"
                                                href="{{ $news->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach


                        @if ($news->hasMorePages())
                            <li class=" text-gray-900"><a
                                    href="{{ $news->appends(request()->all())->nextPageUrl() }}" rel="next">
                                    <x-ri-arrow-right-double-fill class="w-5 h-5" />
                                </a></li>
                        @else
                            <li class="">
                                <x-ri-arrow-right-double-fill class="w-5 h-5 text-gray-400" />
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        @endif
    </x-page-layout>
</x-app-guest-layout>
