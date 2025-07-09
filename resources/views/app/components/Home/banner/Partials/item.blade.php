@php
    $title = $slider['title'];
    $link = $slider['link'];
    $link_text = $slider['link_text'];
    $description = $slider['description'];
    $img = $slider['img'] ?? 'https://fakeimg.pl/1920x530/dbdbdb/909090?text=Banner+Image';
@endphp

<a href="{{ $link ?? '#' }}" class="swiper-slide block relative w-full overflow-hidden">
    <div class="relative w-full" style="aspect-ratio: 1920 / 530;">
        <img src="{{ $img }}" alt="" class="absolute inset-0 w-full h-full object-contain" />
        <div class="absolute inset-0 bg-gradient-to-r from-[#25365E] to-transparent z-10"></div>

        <div class="absolute inset-0 z-20 flex items-center justify-center sm:justify-start px-6 lg:px-20 text-gray-300">
            <div class="max-w-3xl space-y-3 text-center sm:text-left">
                <h1 class="text-[24px] sm:text-[32px] md:text-[48px] lg:text-[60px] font-bold uppercase leading-tight font-lora"
                    data-swiper-parallax-duration="1000"
                    data-swiper-parallax-x="-300"
                    data-swiper-parallax-opacity="0">
                    {{ $title }}
                </h1>
                <p class="text-sm sm:text-base font-light drop-shadow"
                    data-swiper-parallax-duration="1000"
                    data-swiper-parallax-x="-400"
                    data-swiper-parallax-opacity="0">
                    {{ $description ?? '' }}
                </p>

                @if ($link_text && $link)
                    <a href="{{ $link }}"
                       class="relative inline-flex items-center gap-1 leading-normal pb-1 text-gray-100 font-thin text-lg sm:text-xl hover:text-neutral-200 transition group mt-4"
                       data-swiper-parallax-duration="2000"
                       data-swiper-parallax-opacity="0">
                        {{ $link_text }}
                        <x-heroicon-s-arrow-long-right class="text-white w-6 h-6 group-hover:ml-1 transition-all" />
                        <span
                            class="absolute bottom-0 left-0 w-full h-0.5 bg-neutral-200 origin-bottom-right transform transition duration-200 ease-out scale-x-0 group-hover:scale-x-100 group-hover:origin-bottom-left"></span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</a>
