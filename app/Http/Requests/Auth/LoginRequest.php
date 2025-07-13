<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Tenant;
use App\Models\User;

class LoginRequest extends FormRequest
{
    protected $authenticatedUser = null;
    protected $authenticatedTenant = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // Se è una richiesta mobile, usa regole diverse
        if ($this->isMobileLoginRequest()) {
            return [
                'tenant_code' => ['required', 'string', 'size:6'],
                'email' => ['required', 'string', 'email'],
                'pin' => ['required', 'string', 'size:4'],
            ];
        }

        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'tenant_code.required' => 'Il codice azienda è obbligatorio',
            'tenant_code.size' => 'Il codice azienda deve essere di 6 caratteri',
            'pin.required' => 'Il PIN è obbligatorio',
            'pin.size' => 'Il PIN deve essere di 4 cifre',
            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'Inserisci un\'email valida',
            'password.required' => 'La password è obbligatoria',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if ($this->isMobileLoginRequest()) {
            $this->authenticateMobile();
        } else {
            $this->authenticateWeb();
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Autenticazione standard web
     */
    protected function authenticateWeb(): void
    {
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }

    /**
     * Autenticazione mobile con tenant_code + email + PIN
     */
    protected function authenticateMobile(): void
    {
        $tenantCode = strtoupper($this->input('tenant_code'));
        $email = $this->input('email');
        $pin = $this->input('pin');

        $tenant = Tenant::findByAppCode($tenantCode);

        if (!$tenant) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'tenant_code' => 'Codice azienda non valido',
            ]);
        }

        // 2. Inizializza il tenant
        tenancy()->initialize($tenant);

        // 3. Cerca l'utente nel database del tenant
        $user = User::findByEmailAndPin($email, $pin);

        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Credenziali non valide',
            ]);
        }

        // 4. Verifica che l'utente abbia accesso mobile
        if (!$user->hasMobileAccess()) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Accesso mobile non autorizzato',
            ]);
        }

        // 5. Aggiorna ultimo accesso mobile
        $user->updateLastMobileLogin();

        // 6. Autentica l'utente
        Auth::login($user, false);

        // 7. Salva i dati per uso successivo
        $this->authenticatedUser = $user;
        $this->authenticatedTenant = $tenant;
    }

    /**
     * Verifica se è una richiesta di login mobile
     */
    public function isMobileLoginRequest(): bool
    {
        return $this->has('tenant_code') && $this->has('pin');
    }

    /**
     * Ottieni l'utente autenticato
     */
    public function getAuthenticatedUser(): ?User
    {
        return $this->authenticatedUser ?: Auth::user();
    }

    /**
     * Ottieni il tenant autenticato (solo per mobile)
     */
    public function getAuthenticatedTenant(): ?Tenant
    {
        return $this->authenticatedTenant;
    }

    /**
     * Ottieni i dati per la risposta API mobile
     */
    public function getMobileAuthData(): array
    {
        if (!$this->isMobileLoginRequest() || !$this->authenticatedUser || !$this->authenticatedTenant) {
            return [];
        }

        return [
            'user' => [
                'id' => $this->authenticatedUser->id,
                'name' => $this->authenticatedUser->name,
                'email' => $this->authenticatedUser->email,
                'role' => $this->authenticatedUser->role ?? 'customer',
            ],
            'tenant' => [
                'id' => $this->authenticatedTenant->id,
                'domain' => $this->authenticatedTenant->domain,
                'code' => $this->authenticatedTenant->app_code,
                'name' => $this->authenticatedTenant->business_name ?? $this->authenticatedTenant->id,
            ]
        ];
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Per mobile, usa tenant_code nell'identifier
        if ($this->isMobileLoginRequest()) {
            return Str::transliterate(
                Str::lower($this->string('tenant_code') . '|' . $this->string('email')) . '|' . $this->ip()
            );
        }

        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}