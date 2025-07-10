<?php

namespace App\Http\Controllers\App;

use App\Mail\ContactMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
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

        $smtp = $tenant->smtp;

        if (isset($smtp) && $smtp['mail_host'] && $smtp['mail_port'] && $smtp['mail_username'] && $smtp['mail_password'] && $smtp['mail_from_address']){
            Config::set('mail.mailers.smtp.host', $smtp['mail_host']);
            Config::set('mail.mailers.smtp.port', $smtp['mail_port']);
            Config::set('mail.mailers.smtp.username', $smtp['mail_username']);
            Config::set('mail.mailers.smtp.password', $smtp['mail_password']);
            // Config::set('mail.mailers.smtp.encryption', $smtp['mail_encryption']);
            Config::set('mail.from.address', $smtp['mail_from_address']);
            Config::set('mail.from.name', $tenant->business_name ?? "Ecommerce");
        }
        else{
            Log::error("Error: ", ['request' => $request->all(), 'errore' => [
                'numero' => 500,
                'msg' => "SMTP not setup yet",
                'extra_msg' => ""
            ]]);
            return redirect()->back()->with('error', 'Qualcosa è andato storto. Riprova più tardi.');
        }


        // Send the email
        try {
            Mail::send('app.emails.contact', $data, function ($message) use ($data, $smtp) {
                $message->from($smtp['mail_from_address'], $data['business_name']);
                $message->to($smtp['mail_from_address']);
                $message->subject('Contact Form Message');
            });

            return redirect()->back()->with('success', 'Il tuo messaggio è stato inviato con successo!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Qualcosa è andato storto. Riprova più tardi.');
        }
    }



    /* public function send(Request $request)
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
    } */
}
