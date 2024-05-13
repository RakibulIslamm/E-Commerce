@section('title', 'Requested Ecommerce')
<x-app-layout>
    <section class="py-1 w-full">
        @if (session()->has('success'))
            <p class="px-10 py-3 bg-green-400 text-gray-950">{{ session('success') }}</p>
        @endif
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-10">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-2 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-xl text-blueGray-700">
                                Requested Ecommerces
                            </h3>
                        </div>
                    </div>
                </div>
    
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Company
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Email
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Domain
                                </th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @forelse($requested_ecommerces as $request)
                                @include('ecommerce-request.partials.single-request', ['ecommerceRequest' => $request])
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-blueGray-500">
                                        No requested ecommerces found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>