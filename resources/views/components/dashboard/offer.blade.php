<div class="col-md-4 mb-3">
  <div class="card">
    <img class="card-img-top" style="height:300px" src="{{ asset($imageUrl) }}">
    <div class="card-body">
      <div class="d-flex">
        <strong>{{ $name }}</strong>
        @if($productDisabled)
          <span class="text-warning ml-auto">Produit désactivé</span>
        @endif
      </div>
      <small>Du {{ $beginAt }} au {{ $endAt }}</small>
      <a href="{{ route($editRoute, ['offer' => $id]) }}" class="mt-2 btn btn-sm btn-outline-secondary btn-block">Modifier</a>
    </div>
  </div>
</div>
