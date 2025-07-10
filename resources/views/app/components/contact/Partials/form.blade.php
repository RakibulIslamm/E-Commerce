<form action="{{ route('app.contact.send') }}" method="POST" class="p-5 bg-white rounded-lg shadow">
    @csrf
    <div class="space-y-4">
        <div class="w-full flex items-center gap-3">
            <div class="w-full">
                <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Nome completo</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name" autocomplete="name"
                        class="block w-full rounded-md px-3.5 py-2 text-gray-900 border border-gray-200">
                </div>
            </div>

            <div class="w-full">
                <label for="phone-number" class="block text-sm font-semibold leading-6 text-gray-900">Telefono
                    number</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center">
                        <label for="country" class="sr-only">Paese</label>
                        <select id="country" name="country"
                            class="h-full rounded-md border-0 bg-transparent bg-none py-0 pl-4 pr-9 text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm custom-select">
                            <!-- <option>US</option>
                            <option>CA</option> -->
                            <option>EU</option>
                        </select>
                        <svg class="pointer-events-none absolute right-3 top-0 h-full w-5 text-gray-400"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="tel" name="phone-number" id="phone-number" autocomplete="tel"
                        class="block w-full rounded-md px-3.5 py-2 pl-20 text-gray-900 border border-gray-200">
                </div>
            </div>
        </div>
        <div class="w-full">
            <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email</label>
            <div class="mt-1">
                <input type="email" name="email" id="email" autocomplete="email"
                    class="block w-full rounded-md px-3.5 py-2 text-gray-900 border border-gray-200">
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Messaggio</label>
            <div class="mt-1">
                <textarea name="message" id="message" rows="4"
                    class="block w-full rounded-md px-3.5 py-2 text-gray-900 border border-gray-200 focus:ring-0"></textarea>
            </div>
        </div>
        <div class="flex gap-x-4 sm:col-span-2">
            <div class="flex h-6 items-center">
                <input type="checkbox" name="accept_privacy" id="accept_privacy" required
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
            </div>
            <label for="accept_privacy" class="text-sm leading-6 text-gray-600">
                Selezionando questa opzione accetti i nostri
                <a href="/privacy-and-cookie" class="font-semibold text-indigo-600">privacy&nbsp;policy</a>.
            </label>
        </div>
    </div>
    <div class="mt-10">
        <button type="submit"
            class="block w-full rounded-md bg-[#744aaf] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm">Vai!</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.querySelector('button[role="switch"]');
    const toggleSpan = toggleButton.querySelector('span[aria-hidden="true"]');
    
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'accept_privacy';
    hiddenInput.value = 'false';
    toggleButton.parentNode.appendChild(hiddenInput);
    
    toggleButton.addEventListener('click', function() {
        const isChecked = this.getAttribute('aria-checked') === 'true';
        const newState = !isChecked;
        
        this.setAttribute('aria-checked', newState);
        hiddenInput.value = newState ? 'true' : 'false';
        
        if (newState) {
            this.classList.remove('bg-gray-200');
            this.classList.add('bg-indigo-600');
            toggleSpan.classList.remove('translate-x-0');
            toggleSpan.classList.add('translate-x-4');
        } else {
            this.classList.remove('bg-indigo-600');
            this.classList.add('bg-gray-200');
            toggleSpan.classList.remove('translate-x-4');
            toggleSpan.classList.add('translate-x-0');
        }
    });
});
</script>
