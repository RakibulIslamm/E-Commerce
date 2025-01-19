{{-- @dd($ecommerce) --}}
<button title="{{$ecommerce->suspend_tenant ? "Banned": ""}}" onclick="handleSuspend({{ $ecommerce }})" class="text-gray-100 hover:text-white {{$ecommerce->suspend_tenant ? "bg-red-500 hover:bg-red-600": "bg-yellow-500 hover:bg-yellow-600"}} p-1 rounded ml-5"
    type="button">
    @if ($ecommerce->suspend_tenant)
      <x-lucide-lock class="w-4 h-4" />
    @else
      <x-lucide-unlock class="w-4 h-4" />
    @endif
</button>
<form id="suspend-form-{{ $ecommerce->id ?? '' }}" action="{{ route('ecommerce.suspend_tenant', $ecommerce ?? '') }}" method="POST"
    >
    @csrf
    @method('PUT')
    <input name="suspend_tenant" value="{{isset($ecommerce) && $ecommerce->suspend_tenant ? "on" : ''}}" {{isset($ecommerce) && $ecommerce->suspend_tenant ? "checked":''}} type="checkbox" class="sr-only">
</form>
<script>
    const handleSuspend = (ecommerce) => {
        event.preventDefault();
        const str = ecommerce?.suspend_tenant ? "Are you sure you want to permit this site?":"Are you sure you want to suspend?"
        if (confirm(str)) {
            document.getElementById(`suspend-form-${ecommerce.id}`).submit();
        }
    }
</script>