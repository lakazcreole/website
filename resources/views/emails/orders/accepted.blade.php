@component('mail::message')
{!! $message !!}
{{-- <br/>
Paiement en <strong>espèces</strong> à la livraison ou en ligne via Lydia.

@component('mail::button', ['url' => '#'])
Payer via <img src="https://lydia-app.com/assets/img/sitep2p/logo-lydia@2x.png" style="margin: -5px 0px; height: 20px">
@endcomponent --}}

#Récapitulatif de votre commande

@component('emails.orders.components.cart', [
  'lines' => $lines,
  'deliveryPrice' => $deliveryPrice,
  'finalPrice' => $finalPrice,
  'discountDescription' => $discountDescription
  ])
@endcomponent

Le paiement peut être réalisé en espèces, tickets restaurant ou Lydia. Le numéro de téléphone associé au compte Lydia est : 06 29 24 30 90.

#Livraison

##Adresse

@component('emails.orders.components.address', [
  'address1' => $address1,
  'address2' => $address2,
  'address3' => $address3,
  'zip' => $zip,
  'city' => $city,
  ])
@endcomponent

##Coordonnées

@component('emails.orders.components.customer', [
  'firstName' => $customerFirstName,
  'lastName' => $customerLastName,
  'email' => $customerEmail,
  'phone' => $customerPhone,
  ])
@endcomponent

Bonne journée,<br/>
{{ config('app.name') }}
@endcomponent
