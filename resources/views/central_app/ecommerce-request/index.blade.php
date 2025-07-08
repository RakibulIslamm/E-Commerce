@section('title', 'Requested Ecommerce')
<x-central-app-layout>

    <x-slot name="header">
        <div class="w-full flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Requested Ecommerces') }}
            </h2>
            @if (auth()?->user()?->role == 5)
                <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                    <a href="{{ route('request.create') }}"
                        class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                        Request
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <section class="py-1 w-full">
        @if (session()->has('success'))
            <p class="px-10 py-3 bg-green-400 text-gray-950">{{ session('success') }}</p>
        @endif
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-5">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Company
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Email
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Domain
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($requested_ecommerces as $request)
                                @include('central_app.ecommerce-request.partials.single-request', [
                                    'ecommerceRequest' => $request,
                                ])
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-blueGray-500">
                                        Nessun e-commerce richiesto trovato.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-central-app-layout>
