<div
    class="px-20 py-16 w-full h-[calc(100vh_-_105px)] min-h-[450px] relative bg-gradient-to-b from-[#25365E] from-85% to-[#687083] overflow-hidden swiper">
    <div class="swiper-wrapper">
        @include('app.components.banner.Partials.item', ['item' => 'item 1'])
        @include('app.components.banner.Partials.item', ['item' => 'item 1'])
        @include('app.components.banner.Partials.item', ['item' => 'item 1'])
    </div>
    <div class="swiper-pagination"></div>
    <div class="next absolute right-5 top-1/2 transform -translate-y-1/2 text-white w-5 h-5">
        <x-heroicon-o-arrow-small-right />
    </div>
    <div class="prev absolute left-5 top-1/2 transform -translate-y-1/2 text-white w-5 h-5">
        <x-heroicon-o-arrow-small-left />
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper', {
            speed: 800,
            spaceBetween: 100,
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
