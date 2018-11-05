@extends('layouts.dashboard.resource_create')

@section('title', 'Nouvelle réduction')

@section('fields')
  <div class="form-group">
    <label for="name">Nom</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le nom" value="{{ old('name') }}">
    <small>Le nom de la réduction n'est pas montré aux clients, il s'agit simplement d'un identifiant pour vous.</small>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" id="description" placeholder="Entrez la description" value="{{ old('description') }}">
    <small>La description sera affichée dans le panier de l'utilisateur (ex: "Entrée et plat offerts.").</small>
  </div>
  <discount-items-input
    :product-types="{{ json_encode($productTypes) }}"
    :products="{{ json_encode($products) }}"
    :initial-items="{{ json_encode(old('items')) }}"
    class="form-group"
  >
  </discount-items-input>
@endsection
