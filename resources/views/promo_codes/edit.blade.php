@extends('layouts.dashboard.resource_edit')

@section('title', 'Modifier le code promotionnel')

@section('fields')

  <div class="form-group">
    <label for="name">Code</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le code" value="{{ old('name') ?? $name }}">
  </div>
  <div class="form-group">
    <label for="maxUses">Nombre d'utilisations</label>
    <input type="number" name="maxUses" class="form-control" id="maxUses" placeholder="Entrez le nombre d'utilisations" value="{{ old('maxUses') ?? $maxUses }}">
  </div>
  <div class="form-group">
    <label for="discountId">Promotion</label>
    <select class="form-control" name="discountId" id="discountId" value="{{ old('discountId') ?? $discountId }}">
      @foreach($discounts as $discount)
        <option value="{{ $discount->id }}">{{ $discount->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="beginAt">Date de début</label>
      <Datepicker
        :monday-first="true"
        :bootstrap-styling="true"
        id="beginAt"
        name="beginAt"
        format="dd/MM/yyyy"
        placeholder="Choisir une date"
        value="{{ old('beginAt') ?? $beginAt }}"
      />
    </div>
    <div class="form-group col-md-6">
      <label for="endAt">Date de fin</label>
      <Datepicker
        :monday-first="true"
        :bootstrap-styling="true"
        id="endAt"
        name="endAt"
        format="dd/MM/yyyy"
        placeholder="Choisir une date"
        value="{{ old('endAt') ?? $endAt }}"
      />
    </div>
  </div>
@endsection

