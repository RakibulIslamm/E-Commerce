@section('title', 'Ecommerces')

<x-app-layout>
<section class="py-1 bg-blueGray-50 w-full">
    <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
        @if (session()->has('success'))
            <p class="px-10 py-3 bg-green-300 text-gray-950">{{ session('success') }}</p>
        @endif
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-2 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-xl text-blueGray-700">
                            Ecommerces
                        </h3>
                    </div>
                    @if ($user->role == 1 || $user->role == 3)
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                            <a href="/ecommerces/create" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                Add New
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="block w-full overflow-x-auto">
                <table class="items-center bg-transparent w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Domain
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3text-[14px]s uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Email
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ecommerces as $ecommerce)
                            @include('ecommerces.partials.ecommerce', ['ecommerce' => $ecommerce])
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-blueGray-500">
                                    No ecommerces found.
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

