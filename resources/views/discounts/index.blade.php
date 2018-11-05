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
        @if($discount->requiredItems->count())
          <small class="text-muted text-uppercase">Requis</small>
          <ul class="mb-0">
            @foreach($discount->requiredItems as $item)
              <li>{{ $item->percent }} % sur un élément parmi :<br>{{ $item->products->pluck('name')->implode(', ') }}</li>
            @endforeach
          </ul>
        @endif
        @if($discount->optionalItems->count())
          <small class="text-muted text-uppercase">Facultatif</small>
          <ul class="mb-0">
            @foreach($discount->optionalItems as $item)
              <li>{{ $item->percent }} % sur un élément parmi :<br>{{ $item->products->pluck('name')->implode(', ') }}</li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  @endforeach
@endsection
