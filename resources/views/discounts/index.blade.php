@extends('layouts.dashboard.resource_index')

@section('title', 'Réductions')

@section('list')
    @foreach($discounts as $discount)
      <div class="card mb-3">
        <div class="card-header d-flex">
          {{ $discount->name }}
          <a href="{{ route($editRoute, ['discount' => $discount]) }}" class="ml-auto btn btn-sm btn-outline-secondary">Modifier</a>
        </div>
        <div class="card-body">
          <ul class="mb-0">
            @foreach($discount->products as $product)
              <li>
                {{ $product->pivot->percent }} % sur {{ $product->name }} <small class="text-muted text-uppercase">({{ $product->pivot->max_items }} maximum)</small>
                @if($product->pivot->required)
                  <small class="text-muted text-uppercase">Requis</small>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    @endforeach
  </div>
@endsection
