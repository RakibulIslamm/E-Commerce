@if (isset($promotion))

    <div class="w-full h-[500px] relative">
        <img src="{{ $promotion->bg_image ?? '/images/promo_bg.jpg' }}" class="w-full h-full object-cover object-center"
            alt="">
        <div class=" absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-slate-900 to-transparent">
        </div>
        <div
            class="w-full lg:w-8/12 absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 lg:px-20 px-10 leading-none text-center">
            <h3 class=" uppercase lg:text-2xl text-xl font-semibold text-white">{{ $promotion->name }}</h3>

            @if ((float) $promotion->discount_amount)
                <h1 class=" uppercase lg:text-[100px] sm:text-[70px] text-[50px] font-bold  text-yellow-500 py-5">
                    €{{ (float) $promotion->discount_amount }} OFF</h1>
            @elseif((float) $promotion->discount_percentage)
                <h1 class=" uppercase lg:text-[100px] sm:text-[70px] text-[50px] font-bold  text-yellow-500 py-5">
                    {{ $promotion->discount_percentage }}% OFF</h1>
            @endif

            <h3 class="lg:text-3xl text-xl font-semibold text-yellow-500">Spesa minima di
                €{{ $promotion->minimum_spend }}
            </h3>
            <p class=" text-gray-300 mt-5 text-sm font-light sm:w-8/12 w-10/12 mx-auto">{{ $promotion->description }}
            </p>
            <h3 class=" uppercase text-xl font-semibold text-gray-200 mt-2">Codice promozionale: <span
                    class="underline">{{ $promotion->code }}</span>
            </h3>
        </div>
    </div>
@endif
