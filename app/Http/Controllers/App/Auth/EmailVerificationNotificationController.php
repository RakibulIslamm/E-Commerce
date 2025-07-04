<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('app.home', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect('/verify-email')->with('status', 'verification-link-sent');
    }
}
