<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
        /* $loggedInUserRole = $request->user()->role;
        if($loggedInUserRole == 1){
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        elseif($loggedInUserRole == 2){
            return redirect()->intended(route('editor.dashboard', absolute: false));
        }
        elseif($loggedInUserRole == 3){
            return redirect()->intended(route('creator.dashboard', absolute: false));
        }
        elseif($loggedInUserRole == 5){
            return redirect()->intended(route('dashboard', absolute: false));
        }
        else{
            abort(404);
        } */
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
}