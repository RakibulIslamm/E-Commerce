@php
    // Destructuring the prop
    // ['key1' => $value1, 'key2' => $value2] = $item;
@endphp

<div class="swiper-slide flex justify-start items-center">

    <div class="w-6/12 relative z-10 space-y-3 -mt-10 text-gray-300">
        <h1 class="text-[60px] font-bold uppercase leading-none font-lora title" data-swiper-parallax-duration="1000"
            data-swiper-parallax-x="-300" data-swiper-parallax-opacity="0">In
            motion we
            <br class=" lg:hidden"> find
            freedom
            <br>
            and joy
        </h1>
        <p class=" text-base font-extralight filter drop-shadow-2xl" data-swiper-parallax-duration="1000"
            data-swiper-parallax-x="-400" data-swiper-parallax-opacity="0">Lorem ipsum dolor sit amet
            consectetur,
            adipisicing
            elit. Ullam
            pariatur
            quaerat
            dicta rerum
            perspiciatis totam fuga earum unde nihil!
        </p>
        <button
            class="relative inline-flex items-center gap-1 leading-normal pb-1 text-gray-100 font-thin text-2xl hover:text-neutral-200 transition group mt-4"
            data-swiper-parallax-duration="2000" data-swiper-parallax-opacity="0">
            Shop Now
            <x-heroicon-s-arrow-long-right class="text-white w-6 h-6 group-hover:ml-1 transition-all" />
            <span
                class="absolute bottom-0 left-0 w-full h-0.5 bg-neutral-200 origin-bottom-right transform transition duration-200 ease-out scale-x-0 group-hover:scale-x-100 group-hover:origin-bottom-left"></span>
        </button>
    </div>
    <img class="transform -rotate-12 -scale-x-100 z-0 w-[600px]" src="/images/running_shoe.png" alt="">
</div>
