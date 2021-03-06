@extends('layouts.dashboard.resource_create')

@section('title', 'Nouveau produit')

@section('fields')
  <div class="form-group">
    <label for="name">Nom</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le nom" value="{{ old('name') }}" required>
  </div>
  <div class="form-group">
    <label for="type">Type</label>
    <select name="type" class="form-control" required>
      @foreach($productTypes as $type)
        <option value="{{ $type['type'] }}" {{ old('type') === $type['type'] ? 'selected' : '' }}>{{ $type['title'] }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="pieces">Pièces</label>
    <input type="number" name="pieces" class="form-control" id="pieces" placeholder="Entrez le nombre de pièces" value="{{ old('pieces') }}" required>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" id="description" placeholder="Entrez une description" value="{{ old('description') }}">
  </div>
  <div class="form-group">
    <label for="price">Prix</label>
    <div class="input-group">
      <input type="number" name="price" step="0.01" class="form-control" id="price" placeholder="Entrez le prix" value="{{ old('price') }}" required>
      <div class="input-group-append">
        <span class="input-group-text">€</span>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="disabled" id="enabled" value="0">
      <label class="form-check-label" for="enabled">Disponible</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="disabled" id="disabled" value="1" checked>
      <label class="form-check-label" for="disabled">Indisponible</label>
    </div>
  </div>
@endsection
