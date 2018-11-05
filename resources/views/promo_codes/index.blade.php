@extends('layouts.dashboard.resource_index')

@section('title', 'Codes promotionnels')

@section('list')
  <div class="row">
    @foreach($promoCodes as $promoCode)
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">{{ $promoCode->name }}</h5>
          <h6 class="card-subtitle text-muted mb-2">{{ $promoCode->uses }}/{{ $promoCode->max_uses }} utilisations</h6>
          <p class="card-text">{{ $promoCode->discount->name }}</p>
          <a href="{{ route($editRoute, ['promoCode' => $promoCode]) }}" class="card-link">Modifier</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection
