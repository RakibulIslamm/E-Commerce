@section('title', 'News')
<x-app-layout>
    <div class="relative w-full max-w-full flex-grow flex-1 text-right">
        <a href="{{ route('app.dashboard.news.create') }}"
            class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
            Add new
        </a>
        {{-- {{tenant_asset($path)}} --}}
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
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Titolo
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Data di inizio
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Data di fine
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Data di pubblicazione
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Pubblicato
                                </th>
                                <th
                                    class="px-6 align-middle border border-solid  py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Azione
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($news as $item)
                                @include('app.components.dashboard.news.news-item', [
                                    'news' => $item,
                                ])
                            @endforeach
                            {{-- @if (!$sliders->isEmpty())
                                @foreach ($sliders as $item)
                                @endforeach
                            @else
                                <tr class="p-3 block">
                                    <td>No slider found</td>
                                </tr>
                            @endif --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="py-5 space-y-3">
                @if ($news->total() > 0)
                    <p>
                        Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }}
                        items
                    </p>
                @endif

                @if ($news->hasPages())
                    <ul class="flex items-center flex-wrap gap-3 m-0 p-0">
                        {{-- Pagination Elements --}}
                        @foreach ($news->links()->elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $news->currentPage())
                                        <li class="text-gray-400 py-1 px-1"><span>{{ $page }}</span></li>
                                    @else
                                        <li class="text-gray-900"><a class="py-1 px-3 border"
                                                href="{{ $news->appends(request()->all())->url($page) }}">{{ $page }}</a>
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
