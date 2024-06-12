<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $ecommerce['business_name'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $ecommerce['domain'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $ecommerce['tax_code'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        1000
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $ecommerce['email'] }}
    </td>
    <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
        {{ $ecommerce['business_type'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 flex items-center gap-2">
        <a href="/ecommerces/edit/{{ $ecommerce['id'] }}"
            class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded" type="button">
            <x-lucide-edit class="w-4 h-4" />
        </a>
        @include('central_app.ecommerces.partials.delete')
        <a href="#" class="text-gray-100 hover:text-white bg-yellow-500 hover:bg-yellow-600 p-1 rounded"
            type="button">
            <x-lucide-lock class="w-4 h-4" />
        </a>
    </td>
</tr>
