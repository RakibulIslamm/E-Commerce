@section('title', 'Users')
<x-app-layout>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <section class="py-1 w-full">
        <div class="w-full mb-12 xl:mb-0 mx-auto mt-5">
            @if (session()->has('success'))
                <div class="px-10 py-2 bg-green-500 text-white font-semibold flex items-center justify-between"
                    id="session_status">
                    <p>{{ session('success') }}</p>
                    <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="px-10 py-2 bg-red-500 text-white font-semibold flex items-center justify-between"
                    id="session_error">
                    <p>{{ session('error') }}</p>
                    <x-lucide-x-circle class="w-4 h-4 cursor-pointer" id="icon" />
                </div>
            @endif

            <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Nome
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Partita IVA
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Codice Fiscale
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Email
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Stato
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Verificato
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Lista
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Sconto (%)
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    <x-lucide-smartphone class="w-4 h-4 inline mr-1" />
                                    App Mobile
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Azioni
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!$customers->isEmpty())
                                @foreach ($customers as $customer)
                                    @include('app.components.dashboard.user.user-item', [
                                        'customer' => $customer,
                                    ])
                                @endforeach
                            @else
                                <tr class="p-3 block">
                                    <td>Nessun utente trovato</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Paginazione -->
            <div class="py-5 space-y-3">
                @if ($customers->total() > 0)
                    <p>
                        Mostrare {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }}
                        elementi
                    </p>
                @endif

                @if ($customers->hasPages())
                    <ul class="flex items-center flex-wrap gap-3 m-0 p-0">
                        @foreach ($customers->links()->elements as $element)
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $customers->currentPage())
                                        <li class="text-gray-400 py-1 px-1"><span>{{ $page }}</span></li>
                                    @else
                                        <li class="text-gray-900"><a class="py-1 px-3 border"
                                                href="{{ $customers->appends(request()->all())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>

    <!-- Modal elegante per gestione mobile -->
    <div id="mobileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full">
                            <x-lucide-smartphone class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Gestione Mobile</h3>
                            <p class="text-blue-100 text-sm" id="modalUserName">Utente</p>
                        </div>
                    </div>
                    <button id="closeModal" class="bg-white bg-opacity-20 hover:bg-opacity-30 p-2 rounded-full transition-colors">
                        <x-lucide-x class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- Contenuto del modal -->
            <div class="p-6">
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gestione modal
        const modal = document.getElementById('mobileModal');
        const modalContent = document.getElementById('modalContent');
        const modalUserName = document.getElementById('modalUserName');
        const closeModal = document.getElementById('closeModal');

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Chiudi modal cliccando fuori
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // Funzione per aprire il modal con design migliorato
        window.openMobileModal = function(userId, userName) {
            modalUserName.textContent = userName;
            
            modalContent.innerHTML = `
                <div class="space-y-4">
                    <!-- Stato corrente -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <x-lucide-info class="w-4 h-4 mr-2 text-blue-500" />
                            Stato Attuale
                        </h4>
                        <div id="currentStatus" class="text-sm text-gray-600">
                            Caricamento...
                        </div>
                    </div>

                    <!-- Azioni -->
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="enableMobile(${userId})" 
                                class="flex items-center justify-center space-x-2 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-colors font-medium">
                            <x-lucide-check-circle class="w-4 h-4" />
                            <span>Abilita</span>
                        </button>
                        
                        <button onclick="disableMobile(${userId})" 
                                class="flex items-center justify-center space-x-2 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors font-medium">
                            <x-lucide-x-circle class="w-4 h-4" />
                            <span>Disabilita</span>
                        </button>
                        
                        <button onclick="regeneratePin(${userId})" 
                                class="flex items-center justify-center space-x-2 px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors font-medium">
                            <x-lucide-refresh-cw class="w-4 h-4" />
                            <span>Nuovo PIN</span>
                        </button>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
            
            // Carica lo stato corrente
            loadCurrentStatus(userId);
        }

        // Carica stato corrente
        function loadCurrentStatus(userId) {
            fetch(`/dashboard/customers/${userId}/mobile/info`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const info = data.data;
                    const status = info.mobile_access_enabled ? 
                        '<span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium"><span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>Abilitato</span>' : 
                        '<span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium"><span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>Disabilitato</span>';
                    
                    const pin = info.has_mobile_pin ? 
                        '<span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">PIN: ••••</span>' : 
                        '<span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Nessun PIN</span>';
                    
                    const lastLogin = info.last_mobile_login || 'Mai connesso';
                    
                    document.getElementById('currentStatus').innerHTML = `
                        <div class="flex flex-wrap gap-2 mb-2">
                            ${status}
                            ${pin}
                        </div>
                        <div class="text-xs text-gray-500">
                            Ultimo accesso: ${lastLogin}
                        </div>
                    `;
                }
            })
            .catch(error => {
                document.getElementById('currentStatus').innerHTML = 
                    '<span class="text-red-500 text-xs">Errore nel caricamento</span>';
            });
        }

        // Funzioni migliorate con SweetAlert2
        window.enableMobile = function(userId) {
            fetch(`/dashboard/customers/${userId}/mobile/enable`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successo!',
                        html: `Accesso mobile abilitato!<br><strong>PIN: ${data.data.mobile_pin}</strong>`,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Ottimo!'
                    }).then(() => {
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Errore',
                        text: data.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Ok'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Errore di connessione',
                    text: 'Si è verificato un errore durante la comunicazione con il server',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ok'
                });
            });
        }

        window.disableMobile = function(userId) {
            Swal.fire({
                title: 'Sei sicuro?',
                text: "L'utente non potrà più accedere dall'app mobile",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sì, disabilita',
                cancelButtonText: 'Annulla'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/dashboard/customers/${userId}/mobile/disable`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Disabilitato!',
                                text: 'Accesso mobile disabilitato con successo',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Ok'
                            }).then(() => {
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Errore',
                                text: data.message,
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: 'Ok'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore di connessione',
                            text: 'Si è verificato un errore durante la comunicazione con il server',
                            confirmButtonColor: '#ef4444',
                            confirmButtonText: 'Ok'
                        });
                    });
                }
            });
        }

        window.regeneratePin = function(userId) {
            Swal.fire({
                title: 'Rigenera PIN?',
                text: "Il PIN attuale diventerà inutilizzabile",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sì, rigenera',
                cancelButtonText: 'Annulla'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/dashboard/customers/${userId}/mobile/regenerate-pin`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'PIN Rigenerato!',
                                html: `Il nuovo PIN è:<br><strong class="text-2xl">${data.data.mobile_pin}</strong>`,
                                confirmButtonColor: '#3b82f6',
                                confirmButtonText: 'Perfetto!'
                            }).then(() => {
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Errore',
                                text: data.message,
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: 'Ok'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errore di connessione',
                            text: 'Si è verificato un errore durante la comunicazione con il server',
                            confirmButtonColor: '#ef4444',
                            confirmButtonText: 'Ok'
                        });
                    });
                }
            });
        }

        
    </script>
</x-app-layout>