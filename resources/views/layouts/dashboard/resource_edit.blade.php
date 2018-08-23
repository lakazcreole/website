@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="d-flex mb-3">
      <h1 class="mb-0">@yield('title')</h1>
      @isset($destroyRoute)
        <form action="{{ route($destroyRoute, [$routeParameter => $id]) }}" method="POST" class="ml-auto d-inline-flex">
          @method('DELETE')
          @csrf
          <button class="my-auto btn btn-sm btn-outline-danger">Supprimer</button>
        </form>
      @endisset
    </div>
    @include('partials.dashboard.validation_errors')
    <form action="{{ route($updateRoute, [$routeParameter => $id]) }}" method="POST" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      @yield('fields')
      <div class="d-flex">
        <a href="{{ route($indexRoute) }}" class="ml-auto mr-2 btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">Modifier</button>
      </div>
    </form>
  </div>
@endsection
