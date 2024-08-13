@section('title', 'Users')
<x-app-layout>
    <section class="py-1  w-full">
        <div class="w-full mb-12 xl:mb-0 mx-auto mt-5">
            @if (session()->has('success'))
                <div class="px-10 py-2 bg-green-500 text-white font-semibold flex items-center justify-between"
                    id="session_status">
                    <p>{{ session('success') }}</p>
                    <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                </div>
            @endif
            {{-- @dd($users) --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Name
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Vat No.
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Tax Code
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Email
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Status
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    List
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">

                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!$customers->isEmpty())
                                @foreach ($customers as $customer)
                                    @include('app.components.dashboard.user.user-item', [
                                        'customer' => $customer,
                                    ])
                                @endforeach
                            @else
                                <tr class="p-3 block">
                                    <td>No user found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
