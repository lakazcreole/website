@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="d-flex d-flex-row">
      <h1 class="align-self-center">Offres</h1>
      <a href="{{ route('dashboard.offers.create') }}" class="ml-auto btn btn-success align-self-center">Ajouter</a>
    </div>
    @if(isset($success))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $success }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <h2>Offres actives</h2>
    <div class="row">
      @foreach($offers as $offer)
        @if($offer->enabled)
          <div class="col-md-4 mb-4">
            <div class="card">
              <img class="card-img-top" style="height:300px" src="{{ asset($offer->imageUrl) }}">
              <div class="card-body">
                <div class="d-flex">
                  <strong>{{ $offer->name }}</strong>
                  @if($offer->product->disabled)
                    <span class="text-warning ml-auto">Produit désactivé</span>
                  @endif
                </div>
                <small>Du {{ $offer->begin_at }} au {{ $offer->end_at }}</small>
                <div class="row">
                  <div class="col-md-6">
                    <a href="{{ route('dashboard.offers.edit', ['offer' => $offer]) }}" class="mt-2 btn btn-sm btn-outline-secondary btn-block">Modifier</a>
                  </div>
                  <div class="col-md-6">
                    <a href="{{ route('dashboard.offers.destroy', ['offer' => $offer]) }}" class="mt-2 btn btn-sm btn-outline-danger btn-block">Supprimer</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
    <h2>Offres inactives</h2>
    <div class="row">
      @foreach($offers as $offer)
        @if($offer->enabled == false)
          <div class="col-md-4 mb-4">
            <div class="card">
              <img class="card-img-top" style="height:300px" src="{{ asset($offer->imageUrl) }}">
              <div class="card-body">
                <div class="d-flex">
                  <strong>{{ $offer->name }}</strong>
                  @if($offer->product->disabled)
                    <span class="text-warning ml-auto">Produit désactivé</span>
                  @endif
                </div>
                <small>Du {{ $offer->begin_at }} au {{ $offer->end_at }}</small>
                <div class="row">
                  <div class="col-md-6">
                    <a href="{{ route('dashboard.offers.edit', ['offer' => $offer]) }}" class="mt-2 btn btn-sm btn-outline-secondary btn-block">Modifier</a>
                  </div>
                  <div class="col-md-6">
                    <a href="{{ route('dashboard.offers.destroy', ['offer' => $offer]) }}" class="mt-2 btn btn-sm btn-outline-danger btn-block">Supprimer</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@endsection
