@component('mail::message')
# Nouvelle commande

Au travail !

{{ $customerName }} a une commande pour toi :

@component('mail::panel')
@foreach($lines as $line)
- {{ $line->quantity }} {{ $line->product->name }} ({{ $line->totalPrice }} €)
@endforeach
@endcomponent

## Informations
- Client : {{ $customerName }}
- Email : {{ $customerEmail }}
- Tél. : {{ $customerPhone }}
- Addresse : {{ $address }}
- Date : {{ $date }} à {{ $time }}
- Prix total : {{ $totalPrice }} €

## Actions

@component('mail::button', ['url' => $acceptUrl, 'color' => 'green'])
Accepter
@endcomponent
@component('mail::button', ['url' => $declineUrl, 'color' => 'red'])
Refuser
@endcomponent

Bon courage,<br/>
{{ config('app.name') }}
@endcomponent
