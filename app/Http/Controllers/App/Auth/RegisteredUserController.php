<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {

        // dd(tenant()->toArray());
        return view('app.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Il campo nome è obbligatorio.',
            'email.required' => "L'indirizzo email è obbligatorio.",
            'email.email' => "Inserisci un indirizzo email valido.",
            'email.unique' => "Questo indirizzo email è già stato registrato.",
            'password.required' => 'La password è obbligatoria.',
            'password.confirmed' => 'Le due password non corrispondono.',
            'password.required' => 'La password è obbligatoria.',
            'password.min' => 'La password deve contenere almeno :min caratteri.',
            'password.confirmed' => 'Le due password non coincidono.',
            'date_of_birth.required' => 'La data di nascita è obbligatoria.',
            'date_of_birth.date' => 'La data di nascita non è valida.',
            'address.required' => "L'indirizzo è obbligatorio.",
            'postal_code.required' => 'Il CAP è obbligatorio.',
            'city.required' => 'La città è obbligatoria.',
            'province.required' => 'La provincia è obbligatoria.',
            'business_name.required' => 'La ragione sociale è obbligatoria.',
            'telephone.required' => 'Il numero di telefono è obbligatorio.',
            'vat_number.required' => 'La partita IVA è obbligatoria.',
            'sdi_code.required' => 'Il codice SDI è obbligatorio.',
        ];
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'telephone' => 'required|string',
            'vat_number' => ['required', 'string', 'max:255'],
            'pec_address' => ['nullable', 'string', 'max:255'],
            'sdi_code' => ['required', 'string', 'max:255'],
        ], $messages);

        $validate['password'] = Hash::make($validate['password']);
        try {
            $user = User::create($validate);
            event(new Registered($user));
            Auth::login($user);
            $from = $request->input('from') ?? null;
            if (isset($from)) {
                if ($from == 'checkout') {
                    return redirect()->route('app.checkout');
                }
            }
            return redirect(route('app.summary', absolute: false));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
