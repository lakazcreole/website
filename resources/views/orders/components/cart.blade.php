{{-- Dashboard order component --}}

@foreach($orderLines as $line)
  <div class="d-flex flex-row align-items-center">
    {{ $line->quantity . ' ' }}{{ $line->product->pieces > 1 ? "portion(s) de {$line->product->pieces}" : "" }} {{ $line->product->name }}
    <span class="ml-auto">{{ number_format($line->totalPrice, 2) }} €</span>
  </div>
@endforeach
@if($discountDescription)
  <div class="d-flex flex-row align-items-center">
    <div>
      Code promotionnel<br>
      <em>{{ $discountDescription }}</em>
    </div>
    <em class="ml-auto">Offert</em>
  </div>
@endif
<div class="d-flex flex-row align-items-center">
  <em>Livraison</em> <em class="ml-auto">{{ number_format($deliveryPrice, 2) }} €</em>
</div>
<div class="d-flex flex-row align-items-center">
  <strong>Total</strong> <strong class="ml-auto">{{ number_format($finalPrice, 2) }} €</strong>
</div>
