<x-app-checkout-layout>
    @if ($success)
        <div class="w-full h-[300px] flex justify-center items-center flex-col gap-2">
            <x-lucide-circle-check class="w-20 h-20 text-blue-500" />
            <h1 class="text-3xl text-blue-500 font-bold">Order placed successfully</h1>
            <h3 class="text-xl text-gray-700">Your Order Number is: <span
                    class=" underline font-semibold">{{ $order->id }}</span></h3>
            <a href="/" class="flex items-center gap-2 px-5 py-1"><x-bx-arrow-back class="w-5 h-5" /> Go Home</a>
        </div>
    @elseif(!$success)
        <div class="w-full h-[300px] flex justify-center items-center flex-col gap-2">
            <h3 class="text-xl text-red-600">{{$message}}</h3>
            <p>Try again later</p>
        </div>
    @endif

</x-app-checkout-layout>
