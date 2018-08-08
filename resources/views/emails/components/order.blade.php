<!-- Mail Order component -->

@component('mail::table')
| Produits | Prix |
|:--- | ---:|
@foreach($lines as $line)
| {{ $line->quantity . ' ' }}{{ $line->product->pieces > 1 ? "portion(s) de {$line->product->pieces}" : "" }} {{ $line->product->name }} | {{ number_format($line->totalPrice, 2) }} €
@endforeach
@if($deliveryPrice > 0)
| <em>Livraison</em> | <em>{{ number_format($deliveryPrice, 2) }} €</em>
@endif
| <strong>Total</strong> | <strong>{{ number_format($finalPrice, 2) }} €</strong>
@endcomponent
