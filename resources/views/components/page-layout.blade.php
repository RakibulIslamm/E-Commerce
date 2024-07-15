<div class="w-full h-[150px] px-20 bg-slate-200 flex items-center">
    <div>
        <h2 class="text-3xl font-bold py-3">{{ $props['title'] ?? '' }}</h2>
        <div class="flex items-center">

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
<div class="my-8 px-20">
    {{ $slot }}
</div>
