<?php

// dd($categories);
?>

@section('title', 'Categories')
<x-app-layout>
    <div class="relative w-full max-w-full flex-grow flex-1 text-right">
        <a href="{{ route('app.dashboard.categories.create') }}"
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
            Add New
        </a>
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
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Image
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Category Name
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @if (!$categories->isEmpty())
                                @foreach ($categories as $item)
                                    @include('app.components.dashboard.categories.category-item', [
                                        'category' => $item,
                                    ])
                                @endforeach
                            @else
                                <tr class="p-3 block">
                                    <td>No category found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        const handleDelete = (category) => {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this item?')) {
                document.getElementById(`delete-form-${category.id}`).submit();
            }
        }
    </script>
</x-app-layout>
