<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    use Queueable;

    public function toMail($notifiable)
    {
        $tenant = tenant();
        
        if ($tenant && $tenant->business_name) {
            config()->set('app.name', $tenant->business_name);
        }

        return (new MailMessage)
            ->subject('Conferma di registrazione - ' . ($tenant->business_name ?? config('app.name')))
            ->markdown('emails.verify-email', [
                'tenant' => $tenant,
                'registered_user' => $notifiable,
            ])
            ->from(
                $tenant->email ?? config('mail.from.address'),
                $tenant->business_name ?? config('mail.from.name')
            );
    }

    protected function verificationUrl($notifiable)
    {
        $tenant = tenant();

        if ($tenant) {
            return URL::temporarySignedRoute(
                'app.verification.verify', now()->addMinutes(60), [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                    'tenant' => $tenant->id,
                ]
            );
        }

        return URL::temporarySignedRoute(
            'verification.verify', now()->addMinutes(60), [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
