@component('mail::message')
# Ciao {{ $registered_user->name }}!

Ti confermiamo che sei stato registrato con successo.  
Attendi che l'amministratore verifichi il tuo account.

Grazie,  
{{ $tenant->business_name ?? config('app.name') }}

@endcomponent
