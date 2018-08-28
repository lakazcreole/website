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
    <small>La description sera affichée dans le panier de l'utilisateur (ex: "Une boisson gratuite sera ajoutée à votre commande").</small>
  </div>
  <div class="form-group">
    <div class="mb-2">Produits concernés</div>
    @component('components.dashboard.alert', ['type' => 'warning', 'closeable' => false])
      Cette fonctionnalité est en cours de développement. Pour l'instant, c'est à vous d'ajouter les éléments gratuits à la commande du client.
    @endcomponent
    <discount-products-list
      :types="{{ json_encode($productTypes) }}"
      :products="{{ json_encode($products) }}"
      :initial-discount-products="{{ old('products') ? json_encode(old('products')) : json_encode($discountProducts)  }}">
    </discount-products-list>
  </div>
@endsection
