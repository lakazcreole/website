@extends('layouts.dashboard.resource_create')

@section('title', 'Nouveau code promotionnel')

@section('fields')
  <div class="form-group">
    <label for="name">Code</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le code" value="{{ old('name') }}">
  </div>
  <div class="form-group">
    <label for="maxUses">Nombre d'utilisations</label>
    <input type="number" name="maxUses" class="form-control" id="maxUses" placeholder="Entrez le nombre d'utilisations" value="{{ old('maxUses') }}">
  </div>
  <div class="form-group">
    <label for="discountId">Promotion</label>
    <select class="form-control" name="discountId" id="discountId" value="{{ old('discountId') }}">
      @foreach($discounts as $discount)
        <option value="{{ $discount->id }}">{{ $discount->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="beginAt">Date de début</label>
      <Datepicker name="beginAt" format="dd/MM/yyyy" :monday-first="true" :bootstrap-styling="true" id="beginAt" placeholder="Choisir une date" value="{{ old('beginAt') }}"/>
    </div>
    <div class="form-group col-md-6">
      <label for="endAt">Date de fin</label>
      <Datepicker name="endAt" format="dd/MM/yyyy" :monday-first="true" :bootstrap-styling="true" id="endAt" placeholder="Choisir une date" value="{{ old('endAt') }}"/>
    </div>
  </div>
@endsection
