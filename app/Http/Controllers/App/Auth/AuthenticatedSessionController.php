<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // dd($user);

        if (!$user->active) {
            return view('app.pages.lock.index');
        }

        $request->authenticate();

        $request->session()->regenerate();

        $from = $request->input('from') ?? null;
        if (isset($from)) {
            if ($from == 'checkout') {
                return view("app.pages.checkout.index");
            }
        }

        if (Auth::user()->id == 1) {
            return redirect()->intended(route('app.dashboard', absolute: false));
        }
        return redirect()->intended(route('app.summary', absolute: false));
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
