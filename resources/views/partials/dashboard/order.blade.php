<h2>Récapitulatif</h2>
<div class="mb-3">
  @component('orders.components.cart', [
    'orderLines' => $lines,
    'discountDescription' => $discountDescription,
    'deliveryPrice' => $deliveryPrice,
    'finalPrice' => $finalPrice,
    ])
  @endcomponent
</div>
<h2>Informations</h2>
<div class="row mb-3">
  <div class="col-md-6">
    @component('orders.components.address', [
      'address1' => $address1,
      'address2' => $address2,
      'address3' => $address3,
      'zip' => $zip,
      'city' => $city
      ])
    @endcomponent
  </div>
  <div class="col-md-6">
    @component('orders.components.customer', [
      'firstName' => $customerFirstName,
      'lastName' => $customerLastName,
      'email' => $customerEmail,
      'phone' => $customerPhone,
      ])
    @endcomponent
  </div>
</div>
