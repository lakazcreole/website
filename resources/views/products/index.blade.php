@extends('layouts.dashboard')

@section('content')
  <div class="container">
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
