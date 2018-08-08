@extends('layouts.dashboard')

@section('content')
  <div class="container">
    @foreach($orders as $order)
      <div class="card my-3">
        <div class="card-header d-flex flex-row">
          <div>
            {{ strftime('%A %d %B %Y', strtotime($order->date)) }} at {{ $order->time }} <small class="text-muted">#{{ $order->id }}</small>
            @if($order->isAccepted())
              <span class="badge badge-success">Acceptée</span>
            @elseif($order->isDeclined())
              <span class="badge badge-danger">Refusée</span>
            @elseif($order->isCanceled())
              <span class="badge badge-secondary">Annulée</span>
            @else
              <span class="badge badge-warning">En attente</span>
            @endif
          </div>
          <div class="ml-auto d-flex flex-row">
            @if($order->isWaiting())
              <a href="{{ route('dashboard.orders.accept', $order) }}" class="btn btn-sm btn-outline-success">Accepter</a>
              <a href="{{ route('dashboard.orders.decline', $order) }}" class="btn btn-sm btn-outline-danger ml-2">Refuser</a>
              <form action="{{ route('dashboard.orders.cancel', $order) }}" method="POST" class="form-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-2">Annuler</button>
              </form>
            @endif
          </div>
        </div>
        <div class="card-body">
            @foreach($order->lines as $line)
              <div class="d-flex flex-row align-items-center">
                {{ $line->quantity . ' ' }}{{ $line->product->pieces > 1 ? "portion(s) de {$line->product->pieces}" : "" }} {{ $line->product->name }}
                <span class="ml-auto">{{ number_format($line->totalPrice, 2) }} €</span>
              </div>
            @endforeach
            <div class="d-flex flex-row align-items-center">
              <em>Livraison</em> <em class="ml-auto">{{ number_format($order->deliveryPrice, 2) }} €</em>
            </div>
            <div class="d-flex flex-row align-items-center">
              <strong>Total</strong> <strong class="ml-auto">{{ number_format($order->finalPrice, 2) }} €</strong>
            </div>
        </div>
        <div class="card-footer">
          {{ $order->customer->firstName }} {{ $order->customer->lastName }} &bull; {{ $order->customer->email }}<br>
          Tél. : {{ $order->customer->phone }}<br>
          <em>
            {{ $order->address1 }}<br>
            {{ $order->address2 }}<br>
            {{ $order->address3 }}<br>
            {{ $order->zip }}<br>
            {{ $order->city }}
          </em>
          <br>
        </div>
      </div>
    @endforeach
  </div>
@endsection
