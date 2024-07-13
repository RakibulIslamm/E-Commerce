@section('title', $product->DESCRIZIONEBREVE)
<x-app-guest-layout>
    {{-- @dd($product) --}}
    <x-page-layout>
        @section('page_title', 'Product details')
        <div class="w-full">
            <p>{{ $product['DESCRIZIONEBREVE'] }}</p>
        </div>
    </x-page-layout>
</x-app-guest-layout>
