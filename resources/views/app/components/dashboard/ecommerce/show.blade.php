<div class="w-full p-5 bg-white rounded-lg shadow border mt-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold pb-2">Informazioni sull'e-commerce</h2>
        <a href="{{ route('app.corporate-content.ecommerce.edit') }}" class="px-5 py-1 border rounded">Modifica</a>
    </div>
    <div class="mt-4">
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Dominio</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->domain }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Email</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->email }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Codice Fiscale</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->tax_code }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Telefono</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->phone }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Utente REST</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->rest_api_user }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Tipo di attività</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->business_type }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Visualizzazione disponibilità prodotti</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->product_stock_display }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Processo di registrazione</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->registration_process }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Visualizzazione offerte</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->offer_display }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Cifre decimali</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->decimal_places }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Pagamenti accettati</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ implode(', ', $settings->accepted_payments) }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Prezzo con IVA</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->price_with_vat == 0 ? 'Falso' : 'Vero' }}</span>
            </div>
            <div class="w-full h-px my-2 bg-transparent bg-gradient-to-r from-gray-500/40 to-transparent"></div>
        </div>
        <div>
            <div class="flex items-center">
                <span class="flex-[200px] font-semibold text-gray-700">Opzioni taglia e colore</span>
                <span class="flex-[20px] font-semibold">:</span>
                <span class="flex-[500px]">{{ $settings->size_color_options == 0 ? 'Falso' : 'Vero' }}</span>
            </div>
        </div>
    </div>
</div>
