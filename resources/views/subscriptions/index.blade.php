@extends('layouts.dashboard.resource_index')

@section('title', 'Inscrits à la newsletter')

@section('actions')
  <a href="" class="ml-auto btn btn-primary align-self-center">Télécharger</a>
@endsection

@section('list')
  <ul>
  @foreach($subscriptions as $subscription)
    <li>{{ $subscription->email }}</li>
  @endforeach
  </ul>
@endsection
