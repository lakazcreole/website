@component('mail::message')
# Nouveau contact

Laurane, {{ $name }} vous a contacté :

{{ $message }}

## Coordonnées

Email: {{ $email }}

Bonne journée,<br>
{{ config('app.name') }}
@endcomponent
