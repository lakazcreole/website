@extends('layouts.dashboard.resource_edit')

@section('title', 'Modifier la réduction')

@section('fields')
  <div class="form-group">
    <label for="name">Nom</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le nom" value="{{ old('name') ?? $name }}" required>
    <small>Le nom de la réduction n'est pas montré aux clients, il s'agit simplement d'un identifiant pour vous.</small>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" id="description" placeholder="Entrez la description" value="{{ old('description') ?? $description }}">
    <small>La description sera affichée dans le panier de l'utilisateur (ex: "Entrée et plat offerts.").</small>
  </div>
  <discount-items-input
    :product-types="{{ json_encode($productTypes) }}"
    :products="{{ json_encode($products) }}"
    :initial-items="{{ old('items') ? json_encode(old('items')) : json_encode($discountItems) }}"
    class="form-group"
  >
  </discount-items-input>
@endsection

