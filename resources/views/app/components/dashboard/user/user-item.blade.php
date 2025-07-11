<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap break-words">
        {{ $customer->name }}

    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap break-all">
        {{ $customer->vat_number }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4  break-all whitespace-nowrap">
        {{ $customer->tax_id }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap break-all">
        {{ $customer->email }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        @if ($customer->active)
            <form action="{{ route('app.dashboard.customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" class="sr-only" name="active" value="0">
                <button class="bg-green-600 text-white p-[6px] rounded" title="active">
                    <x-lucide-lock class="w-4 h-4" />
                </button>
            </form>
        @else
            <form action="{{ route('app.dashboard.customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" class="sr-only" name="active" value="1">
                <button class="bg-red-600 text-white p-[6px] rounded" title="inactive">
                    <x-lucide-lock-open class="w-4 h-4" />
                </button>
            </form>
        @endif
    </td>


    <td class="text-center">
        @if ($customer->email_verified_at)
            <button
                class="px-4 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold shadow-sm cursor-not-allowed"
                disabled
            >
                {{ __('Verificato') }}
            </button>
        @else
            <form method="POST" action="{{ route('app.dashboard.customers.update', $customer) }}">
                @csrf
                @method('PUT')
                <button
                    id="resend-button"
                    class="px-4 py-1 rounded-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
                    <input type="hidden" name="verify_email" value="1">
                    {{ __('Verificare') }} <span id="countdown"></span>
                </button>
            </form>
        @endif
    </td>


    

    <form action="{{ route('app.dashboard.customers.update', $customer) }}" method="POST">
        @csrf
        @method('PUT')
        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
            <select class="py-1 rounded" name="price_list">
                <option value="1" {{ $customer->price_list == 1 ? 'selected' : '' }}>List 1</option>
                <option value="2" {{ $customer->price_list == 2 ? 'selected' : '' }}>List 2</option>
                <option value="3" {{ $customer->price_list == 3 ? 'selected' : '' }}>List 3</option>
            </select>
        </td>
        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
            <input class="py-1 rounded w-24" name="discount" value="{{$customer->discount}}"/>
        </td>
        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
            <button
                class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 py-1 px-3 rounded">Update</button>
        </td>
    </form>
    {{-- <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 ">
        <div class="flex items-center gap-2">
            <a href="{{ route('app.dashboard.product.edit', $product) }}"
                class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded" type="button">
                <x-lucide-edit class="w-4 h-4" />
            </a>
            @include('app.components.dashboard.product.delete-product')
        </div>
    </td> --}}
</tr>
