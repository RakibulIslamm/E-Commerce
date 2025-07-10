<div class="hidden">
    <button onclick="handleDelete({{ $category }})"
        class="text-gray-100 hover:text-white bg-red-500 hover:bg-red-600 p-1 rounded" type="button">
        <x-lucide-trash class="w-4 h-4" />
    </button>
    <form id="delete-form-{{ $category->id ?? '' }}" action="{{ route('app.dashboard.categories.delete', $category ?? '') }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
