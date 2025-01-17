<a href="{{ route('app.products', ['category' => $category->id]) }}"
    class="relative h-[100px] w-[500px] group rounded-lg overflow-hidden transition-all ease-in-out border swiper-slide bg-slate-300">
    {{-- @dd($category->img); --}}
    <img class="rounded-lg relative z-0 h-full object-cover w-full object-center"
        src="{{ isset($category->img) ? tenant_asset($category->img) : 'https://placehold.co/500x100' }}"
        alt="">
    <h4
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-lg text-white font-bold z-20 drop-shadow-2xl">
        {{isset($category->img) ? "" : $category->nome }}</h4>
     @if (!isset($category->img))
         
     @endif   
    <div
        class="absolute w-full h-full top-0 left-0 {{isset($category->img) ? "hover:bg-black": "bg-[#000000ee] group-hover:opacity-70"}} rounded-lg z-10 transition-all ease-in-out opacity-10">
    </div>
</a>
