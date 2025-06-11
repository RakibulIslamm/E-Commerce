@php
    $title = $slider['title'];
    $link = $slider['link'];
    $link_text = $slider['link_text'];
    $description = $slider['description'];
    $img = $slider['img'];
@endphp

<a href="{{$link ?? '#'}}" class="swiper-slide flex justify-start items-center relative">
    {{-- @dd($slider) --}}
    <img class="z-0 w-full lg:h-[576px] h-[360px] object-cover object-center" src="{{ $img ? $img : 'https://fakeimg.pl/1920x1080/dbdbdb/909090?text=16:9' }}" alt="">
    <div class="w-full sm:h-[576px] h-[360px] absolute top-0 left-0 bg-gradient-to-r from-[#25365E] to-transparent">
    </div>
    <div class="lg:px-20 px-12 lg:py-16 sm:py-8 py-6 lg:w-6/12 w-full absolute z-10 space-y-3 text-gray-300 text-center sm:text-left">
        <h1 class="lg:text-[60px] text-[30px] font-bold uppercase leading-none font-lora title"
            data-swiper-parallax-duration="1000" data-swiper-parallax-x="-300" data-swiper-parallax-opacity="0">
            {{ $title }}
        </h1>
        <p class=" text-base font-extralight filter drop-shadow-2xl" data-swiper-parallax-duration="1000"
            data-swiper-parallax-x="-400" data-swiper-parallax-opacity="0">
            {{ $description ?? '' }}
        </p>
        @if ($link_text and $link)
        <a href="{{ $link }}"
            class="relative inline-flex items-center gap-1 leading-normal pb-1 text-gray-100 font-thin lg:text-2xl sm:text-xl hover:text-neutral-200 transition group mt-4"
            data-swiper-parallax-duration="2000" data-swiper-parallax-opacity="0">
            {{ $link_text ?? "" }}
            @if ($link)
                <x-heroicon-s-arrow-long-right class="text-white w-6 h-6 group-hover:ml-1 transition-all" />
            @endif
            <span
                class="absolute bottom-0 left-0 w-full h-0.5 bg-neutral-200 origin-bottom-right transform transition duration-200 ease-out scale-x-0 group-hover:scale-x-100 group-hover:origin-bottom-left"></span>
        </a>
        @endif
    </div>
</a>
