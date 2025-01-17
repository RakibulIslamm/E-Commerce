<div class="lg:w-[calc(100%_-_160px)] w-[calc(100%_-_40px)] mx-auto py-10 overflow-hidden">
    @include('app.components.Home.categoris.Partials.header')
    <div class="swiper-category">
        <div class="mt-4 swiper-wrapper">
            @foreach ($categories_home as $item)
                @include('app.components.Home.categoris.Partials.category-item', ['category' => $item])
            @endforeach
        </div>
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
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
            },
        });
    });
</script>
