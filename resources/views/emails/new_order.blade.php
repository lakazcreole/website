@component('mail::message')
# Nouvelle commande

Au travail !

{{ $customerName }} a une commande pour toi :

@component('emails.components.order', [ 'lines' => $lines, 'deliveryPrice' => $deliveryPrice, 'fullPrice' => $fullPrice ])
@endcomponent

@if($information != null)
## Attention

{{ $information }}
@endif

## Informations
- Client : {{ $customerName }}
- Email : {{ $customerEmail }}
- Tél. : {{ $customerPhone }}
- Addresse : {{ $address }}
- Code Postal : {{ $zip }}
- Date : {{ $date }} à {{ $time }}
- Livraison : {{ $deliveryPrice }} €
- Prix total : {{ $fullPrice }} €

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
