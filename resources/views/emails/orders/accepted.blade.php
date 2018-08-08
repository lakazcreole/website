@component('mail::message')
{!! $message !!}
{{-- <br/>
Paiement en <strong>espèces</strong> à la livraison ou en ligne via Lydia.

@component('mail::button', ['url' => '#'])
Payer via <img src="https://lydia-app.com/assets/img/sitep2p/logo-lydia@2x.png" style="margin: -5px 0px; height: 20px">
@endcomponent --}}

# Récapitulatif de votre commande

@component('emails.components.order', [ 'lines' => $lines, 'deliveryPrice' => $deliveryPrice, 'finalPrice' => $finalPrice ])
@endcomponent

Le paiement peut être réalisé en espèces, tickets restaurant ou Lydia. Le numéro de téléphone associé au compte Lydia est : 06 29 24 30 90.

# Adresse de livraison
{{ $address1 }}<br/>
{{ $address2 }}<br/>
{{ $address3 }}<br/>
{{ $zip }}<br/>


Bonne journée,<br/>
{{ config('app.name') }}
@endcomponent
