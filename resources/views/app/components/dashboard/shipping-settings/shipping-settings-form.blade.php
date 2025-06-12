<form action="{{ $mode == 'create' ? route('app.shipping-settings.store') : route('app.shipping-settings.update', $shipping_settings->id ?? '') }}" method="POST">
  @method($mode == 'edit' ? 'PUT' : 'POST')
  @csrf

  <!-- Corriere -->
  <div class="mb-4">
      <label for="courier" class="block text-sm font-medium text-gray-700">Corriere</label>
      <input type="text" id="courier" name="courier" value="{{ old('courier', $shipping_settings->courier ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- Ordine Minimo -->
  <div class="mb-4">
      <label for="minimum_order" class="block text-sm font-medium text-gray-700">Ordine Minimo</label>
      <input type="number" step="0.01" id="minimum_order" name="minimum_order" value="{{ old('minimum_order', $shipping_settings->minimum_order ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- Costo Contrassegno -->
  <div class="mb-4">
      <label for="cod_fee" class="block text-sm font-medium text-gray-700">Costo Contrassegno</label>
      <input type="number" step="0.01" id="cod_fee" name="cod_fee" value="{{ old('cod_fee', $shipping_settings->cod_fee ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- Aliquota IVA -->
  <div class="mb-4">
      <label for="vat_rate" class="block text-sm font-medium text-gray-700">Aliquota IVA (%)</label>
      <input type="number" step="0.01" id="vat_rate" name="vat_rate" value="{{ old('vat_rate', $shipping_settings->vat_rate ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
  </div>

  <!-- Regole di Spedizione -->
  <h3 class="text-md font-bold mt-6 mb-4">Regole di Spedizione</h3>
  <div id="rules-container" class="w-full">
      @if(isset($shipping_settings) && $shipping_settings->rules->count())
          @foreach($shipping_settings->rules as $index => $rule)
              <div class="rule-row mb-4 flex space-x-4">
                  <select name="rules[{{ $index }}][zone]" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required>
                    <option value="italy" {{ strcasecmp(old("rules.{$index}.zone", $rule->zone), 'italy') === 0 ? 'selected' : '' }}>Italia</option>
                    <option value="major" {{ strcasecmp(old("rules.{$index}.zone", $rule->zone), 'major') === 0 ? 'selected' : '' }}>Isole Maggiori</option>
                    <option value="minor" {{ strcasecmp(old("rules.{$index}.zone", $rule->zone), 'minor') === 0 ? 'selected' : '' }}>Isole Minori</option>
                  </select>
                  <input type="number" step="0.01" name="rules[{{ $index }}][threshold]" value="{{ old("rules.{$index}.threshold", $rule->threshold) }}" placeholder="Soglia" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
                  <input type="number" step="0.01" name="rules[{{ $index }}][fee]" value="{{ old("rules.{$index}.fee", $rule->fee) }}" placeholder="Costo" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
                  <button type="button" class="text-gray-400 cursor-not-allowed" disabled>Rimuovi</button>
              </div>
          @endforeach
      @else
          <!-- Template vuoto se nessuna regola -->
          <div class="rule-row mb-4 flex space-x-4">
              <select name="rules[0][zone]" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required>
                  <option value="italy" selected>Italia</option>
                  <option value="major">Isole Maggiori</option>
                  <option value="minor">Isole Minori</option>
              </select>
              <input type="number" step="0.01" name="rules[0][threshold]" placeholder="Soglia" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
              <input type="number" step="0.01" name="rules[0][fee]" placeholder="Costo" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
              <button type="button" onclick="removeRule(this)" class="text-red-600">Rimuovi</button>
          </div>
      @endif
  </div>
  <button type="button" onclick="addRule()" class="bg-blue-500 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-600">
      Aggiungi Regola
  </button>

  <!-- Pulsante di invio -->
  <div class="mt-6">
      <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded shadow-sm hover:bg-green-600">
          {{ $mode == 'create' ? "Aggiungi Spedizione" : "Aggiorna Spedizione" }}
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
          <select name="rules[${ruleCount}][zone]" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required>
              <option value="italy">Italia</option>
              <option value="major">Isole Maggiori</option>
              <option value="minor">Isole Minori</option>
          </select>
          <input type="number" step="0.01" name="rules[${ruleCount}][threshold]" placeholder="Soglia" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
          <input type="number" step="0.01" name="rules[${ruleCount}][fee]" placeholder="Costo" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 w-full" required />
          <button type="button" onclick="removeRule(this)" class="text-red-600">Rimuovi</button>
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
