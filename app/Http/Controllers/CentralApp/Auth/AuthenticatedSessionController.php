<?php

namespace App\Http\Controllers\CentralApp\Auth;

use App\Http\Controllers\CentralApp\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Tenant;
use App\Models\User;
class AuthenticatedSessionController extends Controller
{
    
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('central_app.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    /**
     * API Login mobile (solo email + PIN)
     * Cerca automaticamente in tutti i database tenant
     */
    public function mobileLogin(Request $request)
    {
        try {
            $pin = $request->input('pin');

            $tenants = Tenant::all();
            
            foreach ($tenants as $tenant) {
                try {
                    // Inizializza il tenant
                    tenancy()->initialize($tenant);
                    
                    // Cerca l'utente nel database di questo tenant
                    $user = User::findByPin( $pin);
                    if ($user && $user->hasMobileAccess()) {
                        $user->updateLastMobileLogin();

                        return response()->json([
                            'success' => true,
                            'message' => 'pin valido',
                            'domain' => $tenant->domain
                        ]);
                    }
                    
                } catch (\Exception $e) {
                    // Log errore ma continua con il prossimo tenant
                    \Log::warning("Errore durante login per tenant {$tenant->id}: " . $e->getMessage());
                    continue;
                } finally {
                    // Termina il tenancy per passare al prossimo
                    tenancy()->end();
                }
            }

            // Nessun utente trovato in nessun tenant
            return response()->json([
                'success' => false,
                'message' => 'Credenziali non valide o accesso mobile non autorizzato'
            ], 401);

        } catch (\Exception $e) {
            \Log::error('Mobile Login Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Errore interno del server'
            ], 500);
        }
    }
}
