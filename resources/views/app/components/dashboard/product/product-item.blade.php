<tr>
    {{-- @dd($product) --}}
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $product['BARCODE'] }}

    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $product['DESCRIZIONEBREVE'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4  break-all">
        {{ $product->category->nome ?? '' }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $product['GIACENZA'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 ">
        <div class="flex items-center gap-2">
            <a href="#" class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded"
                type="button">
                <x-lucide-edit class="w-4 h-4" />
            </a>
            @include('app.components.dashboard.product.delete-product')
        </div>
    </td>
</tr>
