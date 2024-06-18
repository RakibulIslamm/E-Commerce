@section('title', 'Ecommerces')



<x-central-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ecommerces') }}
            </h2>
            @if ($user->role == 1 || $user->role == 3)
                <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                    <a href="/ecommerces/create"
                        class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                        Add New
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <section class="py-1  w-full">
        <div class="w-full mb-12 xl:mb-0 mx-auto mt-5">
            @if (session()->has('success'))
                <div class="px-10 py-2 bg-green-500 text-white font-semibold flex items-center justify-between"
                    id="session_status">
                    <p>{{ session('success') }}</p>
                    <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                </div>
            @endif
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Business Name
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Domain
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Vat Number
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    No. orders
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Contacts
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase  border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Business Type
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-[14px] uppercase  border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($ecommerces as $ecommerce)
                                @include('central_app.ecommerces.partials.ecommerce', [
                                    'ecommerce' => $ecommerce,
                                ])
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm ">
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
</x-central-app-layout>
<script type="module">
    commonUtils.sessionMessageClose();
</script>
