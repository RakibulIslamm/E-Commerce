<div class="w-full p-5 bg-white rounded-lg shadow border mt-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold pb-2">Ecommerce Info</h2>
        <a href="{{ route('app.corporate-content.ecommerce.edit') }}" class="px-5 py-1 border rounded">Edit</a>
    </div>
    <div class="mt-4">
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Domain</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->domain }}</span>
                {{-- <span class="flex-[500px]">

                    @foreach ($settings->domains as $domain)
                        {{ $domain->domain }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach

                </span> --}}
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Email</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->email }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Tax Code</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->tax_code }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Phone</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->phone }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">REST User</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->rest_api_user }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Business Type</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->business_type }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Product Stock Display</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->product_stock_display }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Registration Process</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->registration_process }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Offer Display</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->offer_display }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Decimal Places</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->decimal_places }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Accepted Payments</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ implode(', ', $settings->accepted_payments) }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Price with VAT</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->price_with_vat == 0 ? 'False' : 'True' }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Size and Color Options</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->size_color_options == 0 ? 'False' : 'True' }}</span>
            </div>
            {{-- <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent">
            </div> --}}
        </div>
    </div>
</div>
