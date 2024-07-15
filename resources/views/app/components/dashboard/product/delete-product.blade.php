{{-- @dd($product) --}}
<button onclick="handleDelete({{ $product }})"
    class="text-gray-100 hover:text-white bg-red-500 hover:bg-red-600 p-1 rounded" type="button">
    <x-lucide-trash class="w-4 h-4" />
</button>
<form id="delete-form-{{ $product->id ?? '' }}" action="{{ route('app.dashboard.product.delete', $product->id) }}"
    method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<script>
    const handleDelete = (product) => {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this item?')) {
            document.getElementById(`delete-form-${product.id}`).submit();
        }
    }
</script>
