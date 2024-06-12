<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap max-w-48">
        <img src="{{ $category['img'] ?? 'http://ecommerce.astersoftware.it/uploads/img_categorie/080000_-1.jpg?185658447' }}"
            class="h-full w-full" alt="">
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $category['name'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 ">
        <div class="flex items-center gap-2">
            <a href="#" class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded"
                type="button">
                <x-lucide-edit class="w-4 h-4" />
            </a>
            <button class="text-gray-100 hover:text-white bg-red-500 hover:bg-red-600 p-1 rounded" type="button">
                <x-lucide-trash class="w-4 h-4" />
            </button>
        </div>
    </td>
</tr>
