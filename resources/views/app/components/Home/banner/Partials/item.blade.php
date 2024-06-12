@php

    $title = $slider['title'];
    $link = $slider['link'];
    $link_text = $slider['link_text'];
    $description = $slider['description'];
    $img = $slider['img'];

@endphp

<div class="swiper-slide flex justify-start items-center relative">
    <img class="z-0 w-full h-[530px]" src="{{ $img ?? '/images/running_shoe.png' }}" alt="">
    <div class="w-full h-[530px] absolute top-0 left-0 bg-gradient-to-r from-[#25365E] to-transparent"></div>
    <div class="px-20 py-16 w-6/12 absolute z-10 space-y-3 text-gray-300">
        <h1 class="text-[60px] font-bold uppercase leading-none font-lora title" data-swiper-parallax-duration="1000"
            data-swiper-parallax-x="-300" data-swiper-parallax-opacity="0">
            {{ $title }}
        </h1>
        <p class=" text-base font-extralight filter drop-shadow-2xl" data-swiper-parallax-duration="1000"
            data-swiper-parallax-x="-400" data-swiper-parallax-opacity="0">
            {{ $description }}
        </p>
        <a href="{{ $link }}"
            class="relative inline-flex items-center gap-1 leading-normal pb-1 text-gray-100 font-thin text-2xl hover:text-neutral-200 transition group mt-4"
            data-swiper-parallax-duration="2000" data-swiper-parallax-opacity="0">
            {{ $link_text }}
            <x-heroicon-s-arrow-long-right class="text-white w-6 h-6 group-hover:ml-1 transition-all" />
            <span
                class="absolute bottom-0 left-0 w-full h-0.5 bg-neutral-200 origin-bottom-right transform transition duration-200 ease-out scale-x-0 group-hover:scale-x-100 group-hover:origin-bottom-left"></span>
        </a>
    </div>
</div>
