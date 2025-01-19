<div
    class="w-full lg:px-20 sm:px-10 px-5 py-5 bg-slate-200 flex items-center sm:justify-start justify-center">
    <div>
        <h2 class="lg:text-3xl sm:text-2xl text-xl font-bold lg:py-3 sm:text-left text-center">
            {{ $props['title'] ?? '' }}</h2>
        <div class="flex items-center flex-wrap justify-center">
            <div class="flex items-center">
                <a href="/" class="flex items-start gap-1">
                    <x-heroicon-s-home class="w-5 h-5" />
                    <span>Home</span>
                </a>
                @if (isset($props['breadcrumbs']) and !$props['breadcrumbs']->isEmpty())
                    <span><x-ri-arrow-drop-right-fill class="w-7 h-7" /></span>
                @endif
            </div>
            @if (isset($props['breadcrumbs']))
                @foreach ($props['breadcrumbs'] as $item)
                    <div class="flex items-center">

                        @if (!$loop->last)
                            <a href="{{ $item->url }}">{{ $item->title }}</a>
                        @else
                            <span class=" opacity-80">{{ $item->title }}</span>
                        @endif

                        @if (!$loop->last)
                            <span><x-ri-arrow-drop-right-fill class="w-7 h-7" /></span>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="lg:my-8 py-5 lg:px-20 sm:px-10 px-5">
    {{ $slot }}
</div>
