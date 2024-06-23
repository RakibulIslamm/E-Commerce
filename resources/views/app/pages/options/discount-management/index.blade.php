@section('title', 'Discounts')
<x-app-layout>
    <div class="w-full flex items-center justify-end">
        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
            <a href="{{ route('app.slider.create') }}"
                class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold  px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Add New
            </a>
        </div>
    </div>
</x-app-layout>
