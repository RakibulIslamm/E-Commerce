<a href=""
    class="relative h-[100px] w-[500px] group rounded-lg overflow-hidden transition-all ease-in-out border swiper-slide bg-slate-300">
    <img class="rounded-lg relative z-0 h-full object-cover w-full object-center"
        src="{{ $category->img ? tenant_asset($category->img) : 'https://www.supergeneral.com/public/images/category/main-catergory.jpg' }}"
        alt="">
    <h4
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-lg text-white font-bold z-20 drop-shadow-2xl">
        {{ $category->nome }}</h4>
    <div
        class="absolute w-full h-full top-0 left-0 bg-[#000000ee] rounded-lg z-10 transition-all ease-in-out opacity-30 group-hover:opacity-70">
    </div>
</a>
