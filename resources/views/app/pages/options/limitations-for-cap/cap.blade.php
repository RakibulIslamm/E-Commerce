<div class="border p-2 rounded-md space-y-2">
    <div class="flex items-center justify-between">
        <p class="text-sm">({{$item->location->province_code}}) {{$item->location->place}} {{$item->location->zipcode}}</p>
        <button onclick="handleDelete({{$item}})" type="button" class="text-red-400 text-sm">Remove</button>
    </div>
</div>

<form id="delete-form-{{ $item->id ?? '' }}" action="{{ route('app.cap.delete', $item) }}"
    method="POST" class="sr-only">
    @csrf
    @method('DELETE')
</form>