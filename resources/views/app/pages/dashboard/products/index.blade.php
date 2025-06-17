@section('title', 'Prodotti')
<x-app-layout>
    <div class="w-full flex items-center justify-end">
        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
            <a href="{{ route('app.dashboard.product.create') }}"
                class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Aggiungi nuovo
            </a>
        </div>
    </div>

    <section class="py-1  w-full">
        <div class="w-full mb-12 xl:mb-0 mx-auto mt-5">
            @if (session()->has('success'))
                <div class="px-10 py-2 bg-green-500 text-white font-semibold flex items-center justify-between"
                    id="session_status">
                    <p>{{ session('success') }}</p>
                    <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                </div>
            @endif

            @if (session()->has('error'))
                <div class="px-10 py-2 bg-red-600 text-white font-semibold flex items-center justify-between"
                    id="session_status">
                    <p>{{ session('error') }}</p>
                    <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                </div>
            @endif
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Barcode
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Articolo
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Categoria
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Giacenza
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!$products->isEmpty())
                                @foreach ($products as $item)
                                    @include('app.components.dashboard.product.product-item', [
                                        'product' => $item,
                                    ])
                                @endforeach
                            @else
                                <tr class="p-3 block">
                                    <td>There is no product</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="py-5 space-y-3">
                @if ($products->total() > 0)
                    <p>
                        Mostrare {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                        elementi
                    </p>
                @endif

                @if ($products->hasPages())
                    <ul class="flex items-center flex-wrap gap-3 m-0 p-0">
                        {{-- Pagination Elements --}}
                        @foreach ($products->links()->elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="text-gray-400 py-1 px-1"><span>{{ $page }}</span></li>
                                    @else
                                        <li class="text-gray-900"><a class="py-1 px-3 border"
                                                href="{{ $products->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
