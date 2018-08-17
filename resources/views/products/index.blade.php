@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="d-flex d-flex-row">
      <h1 class="align-self-center">Produits</h1>
      <a href="{{ route('dashboard.products.create') }}" class="ml-auto btn btn-success align-self-center">Ajouter</a>
    </div>
    @include('dashboard.partials.session_alert')
    @foreach($productTypes as $productType)
      <div class="card my-3">
        <div class="card-header">
          {{ $productType['title'] }}
        </div>
        <ul class="list-group list-group-flush">
          @foreach($products as $product)
            @if($product->type === $productType['type'])
              <li class="list-group-item">
                <div class="d-flex">
                  {{ $product->name }}
                  <div class="ml-auto ">
                    @if($product->disabled)
                      <small class="text-muted">Indisponible</small>
                    @endif
                    <a href="{{ route('dashboard.products.edit', ['product' => $product]) }}" class="btn btn-outline-secondary btn-sm">Modifier</a>
                  </div>
                </div>
{{--                 <product-editor
                  :id="{{ $product->id }}" name="{{ $product->name }}" :initial-disabled="{{ $product->disabled ? 'true' : 'false' }}"
                  api-token="{{ $apiToken }}"
                  >
                </product-editor> --}}
              </li>
            @endif
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
@endsection
