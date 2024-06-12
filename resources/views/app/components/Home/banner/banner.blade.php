@php
    // @dd($sliders);
@endphp

<div {{-- bg-gradient-to-b from-[#25365E] from-85% to-[#687083] --}} class="w-full h-[530px] min-h-[450px] relative overflow-hidden swiper">
    <div class="swiper-wrapper">
        @if (!$sliders->isEmpty())
            @foreach ($sliders as $item)
                @include('app.components.Home.banner.Partials.item', ['slider' => $item])
            @endforeach
        @endif
    </div>
    <div class="swiper-pagination relative z-50"></div>
    <div class="next absolute right-5 top-1/2 transform -translate-y-1/2 text-white w-5 h-5 z-50">
        <x-heroicon-o-arrow-small-right />
    </div>
    <div class="prev absolute left-5 top-1/2 transform -translate-y-1/2 text-white w-5 h-5 z-50">
        <x-heroicon-o-arrow-small-left />
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper', {
            speed: 800,
            // spaceBetween: 100,
            // mousewheel: true,
            // effect: "fade",
            parallax: true,
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
                // pauseOnMouseEnter: true
                waitForTransition: true,
            },
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".next",
                prevEl: ".prev",
            },
            loop: true,
        });
    });
</script>
