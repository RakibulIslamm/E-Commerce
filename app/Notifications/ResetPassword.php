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
        $url = url(route('app.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false)); // false = don't force app URL (helps in tenancy)

        return (new MailMessage)
            ->subject('Reimposta la tua password')
            ->line('Hai ricevuto questa email perché è stata richiesta la reimpostazione della password per il tuo account.')
            ->action('Reimposta Password', $url)
            ->line('Se non hai richiesto la reimpostazione della password, nessuna azione è richiesta.');
    }
}
