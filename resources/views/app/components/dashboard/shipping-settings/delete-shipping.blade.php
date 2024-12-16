<button onclick="handleDelete({{ $setting }})" 
  class="bg-red-500 text-white px-10 py-2 rounded shadow-sm hover:bg-red-600">
    Delete
</button>
<form id="delete-form-{{ $setting->id ?? '' }}" action="{{ route('app.shipping-settings.delete', $setting ?? '') }}"
    method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>