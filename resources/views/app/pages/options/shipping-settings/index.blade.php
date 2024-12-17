@section('title', 'Shippings')
<x-app-layout>
  <div class="my-4 flex justify-end">
    <a href="{{ route('app.shipping-settings.create') }}"
        class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
        Add New
    </a>
  </div>
  <div class="space-y-6">
        @forelse ($shippingSettings as $setting)
            <div class="bg-white shadow rounded p-6">
                <!-- Information Section -->
                <div class="flex-1 space-y-2">
                    <div>
                        <span class="text-gray-600 font-semibold">Courier:</span>
                        <span class="text-gray-800">{{ $setting->courier }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">Minimum Order:</span>
                        <span class="text-gray-800">${{ $setting->minimum_order }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">COD Fee:</span>
                        <span class="text-gray-800">${{ $setting->cod_fee }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-semibold">VAT Rate:</span>
                        <span class="text-gray-800">{{ $setting->vat_rate }}%</span>
                    </div>

                    <!-- Shipping Rules -->
                    @if($setting->rules->isNotEmpty())
                        <div class="mt-4">
                            <h3 class="text-sm font-bold text-gray-700 mb-2">Shipping Rules:</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-gray-800">
                                @foreach ($setting->rules as $rule)
                                        <div class="bg-gray-100 p-3 rounded-lg shadow">
                                        <h3 class="text-xl mb-2">
                                            @if ($rule->zone === 'italy')
                                            Spedizione in Italia
                                            @elseif($rule->zone === 'major')
                                                Spedizione Isole Maggiori
                                            @elseif($rule->zone === 'minor')
                                                Spedizione Isole minori
                                            @endif
                                        </h3>
                                        <div><span class="font-semibold">Fino a: </span> ${{ $rule->threshold }}</div>
                                        <div><span class="font-semibold">addebito di:</span> ${{ $rule->fee }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-4 text-gray-500">No shipping rules defined.</div>
                    @endif
                </div>
                <br>
                <div class="flex items-center gap-5">
                  <a href="{{ route('app.shipping-settings.edit', $setting->id) }}" 
                     class="bg-indigo-500 text-white px-10 py-2 rounded shadow-sm hover:bg-indigo-600">
                      Edit
                  </a>

                  @include('app.components.dashboard.shipping-settings.delete-shipping')
              </div>
            </div>
        @empty
            <div class="text-center text-gray-600">
                No shipping settings available. 
                <a href="{{ route('app.shipping-settings.create') }}" 
                   class="text-blue-500 hover:underline">
                   Create a new one.
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $shippingSettings->links() }}
    </div>
</x-app-layout>

<script>
    const handleDelete = (shipping) => {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this item?')) {
            document.getElementById(`delete-form-${shipping.id}`).submit();
        }
    }
</script>