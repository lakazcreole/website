@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="d-flex d-flex-row">
      <h1 class="align-self-center">Produits</h1>
      <a href="{{ route('dashboard.products.create') }}" class="ml-auto btn btn-success align-self-center">Ajouter</a>
    </div>
    @if(isset($success))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $success }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    @foreach($productTypes as $productType)
      <div class="card my-3">
        <div class="card-header">
          {{ $productType['title'] }}
        </div>
        <ul class="list-group list-group-flush">
          @foreach($products as $product)
            @if($product->type === $productType['type'])
              <li class="list-group-item">
                <product-editor
                  :id="{{ $product->id }}" name="{{ $product->name }}" :disabled="{{ $product->disabled ? 'true' : 'false' }}"
                  api-token="{{ $apiToken }}"
                  >
                </product-editor>
              </li>
            @endif
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
@endsection
