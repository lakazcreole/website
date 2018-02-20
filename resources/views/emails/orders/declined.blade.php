@component('mail::message')
# Commande annulée

Bonjour,

{{ $message }}

Bonne journée,
{{ config('app.name') }}
@endcomponent
