<div
    class="px-20 py-16 w-full h-screen min-h-[450px] relative bg-gradient-to-b from-purple-900 from-80% to-purple-300 overflow-hidden swiper">
    <div class="swiper-wrapper">
        @include('app.components.banner.Partials.item', ['item' => 'item 1'])
        @include('app.components.banner.Partials.item', ['item' => 'item 1'])
        @include('app.components.banner.Partials.item', ['item' => 'item 1'])
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper', {
            speed: 400,
            spaceBetween: 100,
            // mousewheel: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            dynamicBullets: true,
            loop: true,
        });
    });
</script>
