@component('mail::message')
#Nouvelle commande

{{ $customerFirstName }} a une commande pour toi :

@component('emails.orders.components.cart', [
  'lines' => $lines,
  'deliveryPrice' => $deliveryPrice,
  'finalPrice' => $finalPrice,
  'discountDescription' => $discountDescription
  ])
@endcomponent

@if($information)
##Attention

{{ $information }}
@endif

##Livraison

@component('emails.orders.components.time', [
  'date' => $date,
  'time' => $time
  ])
@endcomponent

@component('emails.orders.components.address', [
  'address1' => $address1,
  'address2' => $address2,
  'address3' => $address3,
  'zip' => $zip,
  'city' => $city,
  ])
@endcomponent

## Client

@component('emails.orders.components.customer', [
  'firstName' => $customerFirstName,
  'lastName' => $customerLastName,
  'email' => $customerEmail,
  'phone' => $customerPhone,
  ])
@endcomponent

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
