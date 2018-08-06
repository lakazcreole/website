@component('mail::message')
# Nouvelle commande

Au travail !

{{ $customerName }} a une commande pour toi :

{{-- Issue preventing using component here --}}
@component('mail::table')
| Produits | Prix |
|:--- | ---:|
@foreach($lines as $line)
| {{ $line->quantity . ' ' }}{{ $line->product->pieces > 1 ? "portion(s) de {$line->product->pieces}" : "" }} {{ $line->product->name }} | {{ number_format($line->totalPrice, 2) }} €
@endforeach
| <em>Livraison</em> | <em>{{ number_format($deliveryPrice, 2) }} €</em>
| <strong>Total</strong> | <strong>{{ number_format($fullPrice, 2) }} €</strong>
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
