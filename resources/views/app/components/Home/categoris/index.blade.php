<div class="w-[calc(100%_-_160px)] mx-auto py-10 swiper-category overflow-hidden">
    @include('app.components.Home.categoris.Partials.header')
    <div class="mt-4 swiper-wrapper">
        @include('app.components.Home.categoris.Partials.category-item', ['title' => 'Fish'])
        @include('app.components.Home.categoris.Partials.category-item', ['title' => 'Pasta'])
        @include('app.components.Home.categoris.Partials.category-item', ['title' => 'Boxes'])
        @include('app.components.Home.categoris.Partials.category-item', ['title' => 'Egg'])
        @include('app.components.Home.categoris.Partials.category-item', ['title' => 'Vegetables'])
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper-category', {
            slidesPerView: 1,
            spaceBetween: 10,
            speed: 800,
            mousewheel: true,
            parallax: true,
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
                waitForTransition: true,
            },
            pagination: {
                el: ".swiper-pagination-category",
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".next-category",
                prevEl: ".prev-category",
            },
            freeMode: {
                enabled: true,
                sticky: true,
            },
            loop: true,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                1376: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
            },
        });
    });
</script>
