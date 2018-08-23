@extends('layouts.dashboard.resource_index')

@section('title', 'Produits')

@section('list')
  @foreach($productTypes as $productType)
    <div class="card my-3">
      <div class="card-header d-flex">
        {{ $productType['title'] }}
        <button class="ml-auto btn btn-sm btn-link" type="button" data-toggle="collapse" data-target="#products-{{ $productType['type'] }}-collapse" aria-expanded="false" aria-controls="collapse">Afficher</button>
      </div>
      <div class="collapse" id="products-{{ $productType['type'] }}-collapse">
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
              </li>
            @endif
          @endforeach
        </ul>
      </div>
    </div>
  @endforeach
@endsection
