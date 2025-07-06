<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // generate path (without full domain)
        $path = route('app.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false); // false = relative URL (no central domain prefix)

        
        $url = url($path);

        $tenant = tenant();
        config()->set('app.name', $tenant?->business_name ?? "Ecommerce");

        return (new MailMessage)
            ->subject('Reimposta la tua password')
            ->line('Hai richiesto di reimpostare la tua password.')
            ->action('Reimposta Password', $url)
            ->line('Se non hai fatto questa richiesta, puoi ignorare questa email.');
    }
}
