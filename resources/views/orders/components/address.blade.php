{{-- Dashboard order address component --}}

{{ $address1 }} {{ $address2 }}<br>
{{ $zip }} {{ $city }}
@if($address3)
  <br>
  <em>{{ $address3 }}</em>
@endif
