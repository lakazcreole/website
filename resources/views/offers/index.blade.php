@extends('layouts.dashboard.resource_index')

@section('title', 'Offres')

@section('list')
  <h2 class="mb-3">Actives</h2>
  <div class="row">
    @foreach($offers as $offer)
      @if($offer->enabled)
        @component('components.dashboard.offer', [
          'id' => $offer->id,
          'name' => $offer->name,
          'imageUrl' => $offer->imageUrl,
          'productDisabled' => $offer->product->disabled,
          'beginAt' => date('D M Y', strtotime($offer->begin_at)),
          'endAt' => date('D M Y', strtotime($offer->end_at)),
          'editRoute' => $editRoute
          ])
        @endcomponent
      @endif
    @endforeach
  </div>
  <h2 class="mb-3">Inactives</h2>
  <div class="row">
    @foreach($offers as $offer)
      @if($offer->enabled == false)
        @component('components.dashboard.offer', [
          'id' => $offer->id,
          'name' => $offer->name,
          'imageUrl' => $offer->imageUrl,
          'productDisabled' => $offer->product->disabled,
          'beginAt' => date('D M Y', strtotime($offer->begin_at)),
          'endAt' => date('D M Y', strtotime($offer->end_at)),
          'editRoute' => $editRoute
          ])
        @endcomponent
      @endif
    @endforeach
  </div>
@endsection
