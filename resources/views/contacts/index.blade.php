@extends('layouts.dashboard.resource_index')

@section('title', 'Contacts')

@section('list')
  @foreach($contacts as $contact)
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">{{ $contact->subject }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $contact->name }} &bull; {{ $contact->email }}</h6>
        <p class="card-text">{{ $contact->message }}</p>
      </div>
    </div>
  @endforeach
@endsection
