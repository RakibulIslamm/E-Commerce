<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('app.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (isset($user) && !$user->active) {
            return view('app.pages.lock.index');
        }

        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'email' => 'Email o password non validi.',
                ]);
        }

        $request->session()->regenerate();

        $from = $request->input('from') ?? null;

        if ($from === 'checkout') {
            return redirect()->route('app.checkout');
        }

        return redirect()->intended(
            Auth::user()->id == 1 ? route('app.dashboard', absolute: false) : route('app.summary', absolute: false)
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if (count($cart) > 0) {
            session()->put('cart', $cart);
        }
        return redirect('/');
    }
}
