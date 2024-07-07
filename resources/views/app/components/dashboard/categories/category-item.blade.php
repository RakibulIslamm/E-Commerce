@if ($errors->get('img'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('open-modal-btn').click();
        });
    </script>
@endif

<tr>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap max-w-48">
        <img src="{{ tenant_asset($category['img']) ?? 'http://ecommerce.astersoftware.it/uploads/img_categorie/080000_-1.jpg?185658447' }}"
            class="w-[300px] object-cover border" alt="">
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 whitespace-nowrap">
        {{ $category['nome'] }}
    </td>
    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] p-4 ">
        <div class="flex items-center gap-2">
            <button id="open-modal-btn" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-category-photo-{{ $category['id'] }}')"
                class="text-gray-100 hover:text-white bg-indigo-500 hover:bg-indigo-600 p-1 rounded cursor-pointer"
                type="button">
                <x-lucide-edit class="w-4 h-4" />
            </button>

            @include('app.components.dashboard.categories.add-category-image')
            @include('app.components.dashboard.categories.delete')
        </div>
    </td>
</tr>
