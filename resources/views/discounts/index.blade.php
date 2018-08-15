@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="d-flex d-flex-row">
      <h1 class="align-self-center">Réductions</h1>
      <a href="{{ route('dashboard.discounts.create') }}" class="ml-auto btn btn-success align-self-center">Ajouter</a>
    </div>
    @if(session('success'))
      @component('dashboard.components.alert-success')
        {{ session('success') }}
      @endcomponent
    @endif
    @foreach($discounts as $discount)
      <div class="card mb-3">
        <div class="card-header d-flex">
          {{ $discount->name }}
          <div class="ml-auto">
            <a href="{{ route('dashboard.discounts.edit', ['discount' => $discount]) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
            <form action="{{ route('dashboard.discounts.destroy', ['discount' => $discount]) }}" method="POST" class="d-inline-block">
                @method('DELETE')
                @csrf
                <button class="ml-2 btn btn-sm btn-outline-danger">Supprimer</button>
            </form>
          </div>
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
