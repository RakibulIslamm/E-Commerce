@section('title', 'Richiesta dettagli')
<x-central-app-layout>
    <div class="w-8/12 bg-white shadow border my-10 p-5 space-y-4">
        <p class="text-lg">
            <span class="font-bold">Azienda:</span> {{ $ecommerceRequest['company_name'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Email:</span> {{ $ecommerceRequest['email'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Dominio:</span> {{ $ecommerceRequest['domain'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Partita iva:</span> {{ $ecommerceRequest['vat_number'] }}
        </p>
        <p class="text-lg">
            <span class="font-bold">Tipologia Business:</span> {{ $ecommerceRequest['business_type'] }}
        </p>
    </div>
</x-central-app-layout>
