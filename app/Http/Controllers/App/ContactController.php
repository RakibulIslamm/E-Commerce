<?php

namespace App\Http\Controllers\App;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController
{
    public function index(Request $request)
    {
        return view("app.pages.contact");
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            // 'phone-number' => 'required|string',
            // 'dialCode' => 'required|string'
        ]);
        // dd($validated);

        Mail::to(env('MAIL_USERNAME'))->send(new ContactMail($validated));
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
