<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap max-w-48">
        {{ $promotion['name'] }}
        @if ($promotion['active'])
            <sup>active</sup>
        @endif
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $promotion['start_date'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $promotion['end_date'] }}
    </td>
    {{-- @dd($promotion) --}}
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        @if ((float) $promotion['discount_amount'])
            ${{ $promotion['discount_amount'] }}
        @elseif((int) $promotion['discount_percentage'])
            {{ $promotion['discount_percentage'] }}%
        @endif
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 ">
        <div class="flex items-center gap-2">
            <a href="{{ route('app.promotions.edit', $promotion) }}"
                class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded cursor-pointer"
                type="button">
                <x-lucide-edit class="w-4 h-4" />
            </a>
            @include('app.components.dashboard.promotion.delete-promo')
        </div>
    </td>
</tr>
