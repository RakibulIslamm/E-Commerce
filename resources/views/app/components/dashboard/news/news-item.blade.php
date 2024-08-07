<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $news->title }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $news->start_date }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $news->end_date }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $news->publication_date }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $news->published ? 'True' : 'False' }}
    </td>

    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 ">
        <div class="flex items-center gap-2">
            <a href="{{ route('app.dashboard.news.edit', $news) }}"
                class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded cursor-pointer"
                type="button">
                <x-lucide-edit class="w-4 h-4" />
            </a>

            <button class="text-gray-100 hover:text-white bg-red-500 hover:bg-red-600 p-1 rounded" type="button">
                <x-lucide-trash class="w-4 h-4" />
            </button>
        </div>
    </td>
</tr>
