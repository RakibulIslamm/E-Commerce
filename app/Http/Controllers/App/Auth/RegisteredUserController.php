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
        ]);

        $validate['password'] = Hash::make($validate['password']);
        try {
            $user = User::create($validate);
            event(new Registered($user));
            Auth::login($user);
            $from = $request->input('from') ?? null;
            if (isset($from)) {
                if ($from == 'checkout') {
                    return view("app.pages.checkout.index");
                }
            }
            return redirect(route('app.summary', absolute: false));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
