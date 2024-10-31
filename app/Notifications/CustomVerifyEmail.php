<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        if (tenant()) {
            return URL::temporarySignedRoute(
                'app.verification.verify', now()->addMinutes(5), [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                    'tenant' => $notifiable->id,
                ]
            );
        } else {
            return URL::temporarySignedRoute(
                    'verification.verify', now()->addMinutes(5), [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification())
                ]
            );
        }
    }
}
