@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <h1>Nouvelle réduction</h1>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="{{ route('dashboard.discounts.store') }}" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le nom" value="{{ old('name') }}" required>
        <small>Le nom de la réduction n'est pas montré aux clients, il s'agit simplement d'un identifiant pour vous.</small>
      </div>
      <div class="form-group">
        <div class="mb-2">Produits concernés</div>
        <discount-products-list :types="{{ json_encode($productTypes) }}" :products="{{ json_encode($products) }}" :initial-discount-products="{{ json_encode(old('products')) }}">
        </discount-products-list>
      </div>
      <a href="{{ route('dashboard.discounts.index') }}" class="btn btn-outline-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
  </div>
@endsection
