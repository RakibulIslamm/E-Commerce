<?php

// dd($categories);
?>

@section('title', 'Categories')
<x-app-layout>
    @if ($errors->has('error'))
    <div class="bg-red-100 text-red-700 border-l-4 border-red-500 p-4 mb-4">
        <strong>{{ $errors->first('error') }}</strong>
    </div>
    @endif
    <div class="relative w-full max-w-full flex-grow flex-1 text-right">
        <a href="{{ route('app.dashboard.categories.create') }}"
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
            Aggiungi nuovo
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
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full  shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Immagine
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Nome della categoria
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Codice
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Azione
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!$dashboard_categories->isEmpty())
                                @foreach ($dashboard_categories as $item)
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
            <div class="py-5 space-y-3">
                @if ($dashboard_categories->total() > 0)
                    <p>
                        Mostrare {{ $dashboard_categories->firstItem() }} to {{ $dashboard_categories->lastItem() }} of {{ $dashboard_categories->total() }}
                        elementi
                    </p>
                @endif

                @if ($dashboard_categories->hasPages())
                    <ul class="flex items-center flex-wrap gap-3 m-0 p-0">
                        {{-- Pagination Elements --}}
                        @foreach ($dashboard_categories->links()->elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $dashboard_categories->currentPage())
                                        <li class="text-gray-400 py-1 px-1"><span>{{ $page }}</span></li>
                                    @else
                                        <li class="text-gray-900"><a class="py-1 px-3 border"
                                                href="{{ $dashboard_categories->appends(request()->all())->url($page) }}">{{ $page }}</a>
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

    <script>
        const handleDelete = (category) => {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this item?')) {
                document.getElementById(`delete-form-${category.id}`).submit();
            }
        }
    </script>
</x-app-layout>
