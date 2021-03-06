@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="d-flex d-flex-row mb-3">
      <h1 class="align-self-center mb-0">
        @yield('title')
      </h1>
      @yield('actions')
      @isset($createRoute)
        <a href="{{ route($createRoute) }}" class="ml-auto btn btn-success align-self-center">Ajouter</a>
      @endisset
    </div>
    <div class="mb-3">
      @if(session('success'))
        @component('components.dashboard.alert', ['type' => 'success'])
          {{ session('success') }}
        @endcomponent
      @endif
    </div>
    @yield('list')
  </div>
@endsection
