@section('title', 'Limita per località')
<x-app-layout>
    <div class="w-full flex items-start gap-5">
        <div class="w-5/12 flex items-start gap-3">
            <div class="w-full">
                <label for="cap-search" class="inline-block font-semibold mb-1">Seleziona località</label>
                <input id="cap-search" type="text" placeholder="Ricerca..." class="rounded-md w-full">
                <div class="w-full rounded-md mt-1 hidden" id="cap-list-select">
                    <div class="bg-white p-4 rounded-b-md overflow-hidden overflow-y-auto max-h-[300px] space-y-2"
                        id="search-list-container">
                        <div id="search-item-list" class="space-y-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-7/12">
            <div class="w-full hidden" id="selected-container">
                <div class="inline-block font-semibold mb-1">Selezionata</div>
                <form id="form" class="w-full rounded-md">
                    <div class="border p-2 rounded-md space-y-2 max-h-[300px] overflow-y-auto" id="selected-items">

                    </div>
                    <button
                        type="submit"
                        class="bg-indigo-500 text-white active:bg-indigo-600 font-bold  px-3 py-1 rounded outline-none focus:outline-none ease-linear transition-all duration-150 mt-3">
                        Save
                    </button>
                </form>
                <hr class="my-5">
            </div>
            <h3 class="font-semibold mb-1">Limita la spedizione per località</h3>
            <div class="w-full bg-white rounded-md p-4 space-y-2 max-h-[400px] overflow-y-auto">
                @foreach ($available_locations as $item)
                    @include('app.pages.options.limitations-for-cap.cap', ['item' => $item])
                @endforeach
            </div>
        </div>
    </div>


</x-app-layout>

<script>
    const capListSelect = document.getElementById('cap-list-select');
    const capSearch = document.getElementById('cap-search');
    const container = document.getElementById('search-list-container');
    const selectedContainer = document.getElementById('selected-container');
    const selectedItems = document.getElementById('selected-items');
    const list = document.getElementById('search-item-list');

    const locationMap = new Map(@json($available_locations).map(location => [location.location_id, location]));

    let selectedLocations = [];

    document.getElementById('form').addEventListener('submit', async (e) => {
        e.preventDefault(); 
        if (!selectedLocations.length) {
            alert("Please select at least one location.");
            return;
        }

        try {
            const response = await fetch('/api/add-cap', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    locations: selectedLocations.map(location => ({
                        location_id: String(location.id),
                        postal_code: String(location.zipcode)
                    }))
                })
            });

            const data = await response.json();

            if (data.code !== 201) {
                alert('Error: ' + data.message);
            } else {
                // alert('Locations added successfully');
                window.location.reload();
            }
        } catch (error) {
            alert("Something went wrong");
            console.error(error);
        }
    });

    capSearch.addEventListener('focus', () => {
        capListSelect.classList.remove('hidden');
    })

    capSearch.addEventListener('blur', () => {
        // capListSelect.classList.add('hidden');
    })

    const debouncedGetLocations = debounce(getLocations, 1000);
    capSearch.addEventListener('input', (e) => {
        const text = e.target.value;
        debouncedGetLocations(text);
    })

    function handleSelectLocation(e) {
        const checkbox = e.target;
        const locationId = checkbox.value;
        const isChecked = checkbox.checked;
        const locationData = checkbox.dataset.location;
        if (locationData) {
            const location = JSON.parse(locationData);
            const exists = selectedLocations.some(item => item.id === location.id);

            if (isChecked) {
                if (!exists) {
                    selectedLocations.push(location);
                }
            } else {
                if (exists) {
                    selectedLocations = selectedLocations.filter(item => item.id !== location.id);
                }
            }
        }

        if (selectedLocations.length) {
            selectedContainer.classList.remove('hidden')
        } else {
            selectedContainer.classList.add('hidden')
        }

        renderSelectedLocation()
    }

    function deselectLocation(id) {
        const checkbox = document.getElementById(`cap-${id}`);
        const exists = selectedLocations.some(item => item.id === id);
        if (exists) {
            selectedLocations = selectedLocations.filter(item => item.id !== id);
        }

        const isChecked = checkbox?.checked;
        if (isChecked) {
            checkbox.checked = false;
        }
        renderSelectedLocation()
    }

    function renderSelectedLocation() {
        selectedItems.innerHTML = '';
        selectedLocations.forEach(location => {
            const element = document.createElement('div');
            element.classList.add('flex', 'items-center', 'justify-between')

            element.innerHTML = `
                <p class="text-sm">(${location.province_code}) ${location.place} ${location.zipcode}</p>
                <button type="button" onclick="deselectLocation(${location.id})" class="text-blue-400 text-sm">Deselect</button>
            `
            selectedItems.appendChild(element);
        });
    }



    function getLocations(searchText) {
        if (!searchText || searchText.length < 3) return;
        fetch(`/api/locations?search=${searchText}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data?.locations?.length) {
                        renderSearchLocations(data?.locations)
                    }
                    else{
                        list.innerHTML = 'No location found';
                    }
                } else {
                    console.error('Failed to retrieve locations.');
                }
            })
            .catch(error => console.error('Error:', error));
    }


    function renderSearchLocations(locations) {
        list.innerHTML = '';
        let count = 0;
        for (const location of locations) {
            if(!locationMap.has(location.id)){
                count += 1;
                const element = document.createElement('div');
                element.classList.add('flex', 'items-center', 'gap-2')
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'cap-item';
                checkbox.id = `cap-${location.id}`;
                checkbox.value = location.id;
                checkbox.dataset.location = JSON.stringify(location);
                checkbox.addEventListener('change', handleSelectLocation);

                const label = document.createElement('label');
                label.htmlFor = checkbox.id;
                label.textContent = `${location.province_code} ${location.place} ${location.zipcode}`;

                element.appendChild(checkbox);
                element.appendChild(label);
                list.appendChild(element);
            }
        }
        if(count < 1){
            list.innerHTML = 'No location found';
        }
    }


    function debounce(func, delay, id) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    const handleDelete = (cap) => {
        event.preventDefault();
        if (confirm('Are you sure you want to delete?')) {
            document.getElementById(`delete-form-${cap.id}`).submit();
        }
    }
</script>


{{-- <script>
    const selectInputCap = document.getElementById('cap-select');
    const capListSelect = document.getElementById('cap-list-select');

    selectInputCap.addEventListener('click', () => {
        capListSelect.classList.toggle('hidden');
    })

     document.addEventListener('change', () => {
         const selectedCaps = Array.from(document.querySelectorAll('.cap-item:checked'));
         console.log(selectInputCap);
     })
</script> --}}
