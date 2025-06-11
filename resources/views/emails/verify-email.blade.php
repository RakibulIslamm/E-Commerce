@component('mail::message')
# Ciao {{ $user->name }}!

Per favore conferma il tuo indirizzo email cliccando sul pulsante qui sotto.

@component('mail::button', ['url' => $url])
Verifica Email
@endcomponent

Se non hai creato un account, nessuna azione è richiesta.

Thanks,  
{{ $tenant->business_name ?? config('app.name') }}

@endcomponent
