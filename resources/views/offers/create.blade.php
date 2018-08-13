@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <h1>Nouvelle offre</h1>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="{{ route('dashboard.offers.store') }}" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le nom" value="{{ old('name') }}" required>
        <small>Le nom de l'offre n'est pas montré aux clients, il s'agit simplement d'un identifiant pour vous.</small>
      </div>
      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control-file" id="image" value="{{ old('image') }}">
      </div>
      <div class="form-group">
        <label for="product">Produit mis en avant</label>
        <select class="form-control" name="product" id="product" value="{{ old('product') }}">
          @foreach($productTypes as $productType)
            <optgroup label="{{ $productType['title'] }}">
              @foreach($products as $product)
                @if($product->type == $productType['type'])
                  <option value="{{ $product->id }}">
                    {{ $product->name }}
                    @if($product->disabled)
                      &nbsp;- Désactivé
                    @endif
                  </option>
                @endif
              @endforeach
            </optgroup>
          @endforeach
        </select>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="begin_date">Date de début</label>
          <Datepicker name="begin_date" format="dd/MM/yyyy" :monday-first="true" :bootstrap-styling="true" id="begin_date" placeholder="Choisir une date" value="{{ old('begin_date') }}"/>
        </div>
        <div class="form-group col-md-6">
          <label for="end_date">Date de fin</label>
          <Datepicker name="end_date" format="dd/MM/yyyy" :monday-first="true" :bootstrap-styling="true" id="end_date" placeholder="Choisir une date" value="{{ old('end_date') }}"/>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="enabled" id="enabled" value="1" checked>
          <label class="form-check-label" for="enabled">Active</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="enabled" id="disabled" value="0">
          <label class="form-check-label" for="disabled">Inactive</label>
        </div>
      </div>
      <a href="{{ route('dashboard.offers.index') }}" class="btn btn-outline-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
  </div>
@endsection
