<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
        {{ $ecommerceRequest['company_name'] }}
    </td>
    <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
        {{ $ecommerceRequest['email'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
        <a href="{{ route('request.show', $ecommerceRequest['id']) }}" class="bg-indigo-500 text-white active:bg-indigo-600 text-[14px] font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
            View details
        </a>
    </td>
</tr>