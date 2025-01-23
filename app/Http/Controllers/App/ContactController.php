<?php

namespace App\Http\Controllers\App;

use App\Mail\ContactMail;
use Exception;
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
        $tenant = tenant();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'text' => $validated['message'],
            'business_name' => $tenant->business_name,
        ];
        
        // Send the email
        try{
            $result = Mail::send('app.emails.contact', $data, function ($message) use ($data) {
                $message->from('nilakash01688@gmail.com', $data['business_name']);
                $message->to('nilakash01688@gmail.com');
                $message->subject('New Contact Form Message');
            });
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Something went wrong, Please try gain later');
        }
    }

}
