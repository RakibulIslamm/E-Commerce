<form action="{{ $mode == 'create' ? route('app.shipping-settings.store') : route('app.shipping-settings.update', $shipping_settings->id ?? '') }}" method="POST">
  @method($mode == 'edit' ? 'PUT' : 'POST')
  @csrf

  <!-- Courier -->
  <div class="mb-4">
      <label for="courier" class="block text-sm font-medium text-gray-700">Courier</label>
      <input type="text" id="courier" name="courier" value="{{ old('courier', $shipping_settings->courier ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- Minimum Order -->
  <div class="mb-4">
      <label for="minimum_order" class="block text-sm font-medium text-gray-700">Minimum Order</label>
      <input type="number" step="0.01" id="minimum_order" name="minimum_order" value="{{ old('minimum_order', $shipping_settings->minimum_order ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- COD Fee -->
  <div class="mb-4">
      <label for="cod_fee" class="block text-sm font-medium text-gray-700">Cash on Delivery Fee</label>
      <input type="number" step="0.01" id="cod_fee" name="cod_fee" value="{{ old('cod_fee', $shipping_settings->cod_fee ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- VAT Rate -->
  <div class="mb-4">
      <label for="vat_rate" class="block text-sm font-medium text-gray-700">VAT Rate (%)</label>
      <input type="number" step="0.01" id="vat_rate" name="vat_rate" value="{{ old('vat_rate', $shipping_settings->vat_rate ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- Shipping Rules -->
  <h3 class="text-md font-bold mt-6 mb-4">Shipping Rules</h3>
  <div id="rules-container" class="w-full">
      @if(isset($shipping_settings) && $shipping_settings->rules->count())
      {{-- @dd($shipping_settings->rules) --}}
          @foreach($shipping_settings->rules as $index => $rule)
              <div class="rule-row mb-4 flex space-x-4">
                  <select name="rules[{{ $index }}][zone]" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required>
                    <option value="italy" {{ strcasecmp(old("rules.{$index}.zone", $rule->zone), 'italy') === 0 ? 'selected' : '' }}>Italy</option>
                    <option value="major" {{ strcasecmp(old("rules.{$index}.zone", $rule->zone), 'major') === 0 ? 'selected' : '' }}>Major Island</option>
                    <option value="minor" {{ strcasecmp(old("rules.{$index}.zone", $rule->zone), 'minor') === 0 ? 'selected' : '' }}>Minor Island</option>
                  </select>
                  <input type="number" step="0.01" name="rules[{{ $index }}][threshold]" value="{{ old("rules.{$index}.threshold", $rule->threshold) }}" placeholder="Threshold" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
                  <input type="number" step="0.01" name="rules[{{ $index }}][fee]" value="{{ old("rules.{$index}.fee", $rule->fee) }}" placeholder="Fee" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
                  <button type="button" class="text-gray-400 cursor-not-allowed" disabled>Remove</button>
              </div>
          @endforeach
      @else
          <!-- Empty Template if no existing rules -->
          <div class="rule-row mb-4 flex space-x-4">
              <select name="rules[0][zone]" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required>
                  <option value="italy" selected>Italy</option>
                  <option value="major">Major Island</option>
                  <option value="minor">Minor Island</option>
              </select>
              <input type="number" step="0.01" name="rules[0][threshold]" placeholder="Threshold" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
              <input type="number" step="0.01" name="rules[0][fee]" placeholder="Fee" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
              <button type="button" onclick="removeRule(this)" class="text-red-600">Remove</button>
          </div>
      @endif
  </div>
  <button type="button" onclick="addRule()" class="bg-blue-500 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-600">
      Add Rule
  </button>

  <!-- Submit Button -->
  <div class="mt-6">
      <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded shadow-sm hover:bg-green-600">
          {{$mode == 'create' ? "Add Shipping":"Update Shipping"}}
      </button>
  </div>
</form>

<script>
  let ruleCount = {{ isset($shipping_settings) ? $shipping_settings->rules->count() : 1 }};

  function addRule() {
      const container = document.getElementById('rules-container');
      const newRow = document.createElement('div');
      newRow.className = 'rule-row mb-4 flex space-x-4';
      newRow.innerHTML = `
          <input type="text" name="rules[${ruleCount}][zone]" placeholder="Zone" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
          <input type="number" step="0.01" name="rules[${ruleCount}][threshold]" placeholder="Threshold" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
          <input type="number" step="0.01" name="rules[${ruleCount}][fee]" placeholder="Fee" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
          <button type="button" onclick="removeRule(this)" class="text-red-600">Remove</button>
      `;
      container.appendChild(newRow);
      ruleCount++;
    }
    
    function removeRule(button) {
      if(ruleCount > 1){
        button.parentElement.remove();
        ruleCount--;
      }
    }
</script>
