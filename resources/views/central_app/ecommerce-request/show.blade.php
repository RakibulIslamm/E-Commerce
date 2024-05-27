@section('title', 'Request details')
<x-central-app-layout>
    <div class="w-8/12 bg-white shadow border my-10 p-5 space-y-4">
        <p class="text-lg">
            <span class="font-bold">Company:</span> {{ $ecommerceRequest['company_name'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Email:</span> {{ $ecommerceRequest['email'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Domain:</span> {{ $ecommerceRequest['domain'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">VAT Number:</span> {{ $ecommerceRequest['vat_number'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Business Type:</span> {{ $ecommerceRequest['business_type'] }}
        </p>
    </div>
</x-central-app-layout>
