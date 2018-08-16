@extends('layouts.dashboard')

@section('content')
  <div class="container">
    @include('dashboard.partials.session_alert')
    @foreach($orders as $order)
      <div class="card my-3">
        <div class="card-header d-flex flex-row">
          <div>
            @component('orders.components.time', [
              'date' => $order->date,
              'time' => $order->time
              ])
            @endcomponent
             <small class="text-muted">#{{ $order->id }}</small>
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
            <button class="btn btn-sm btn-link" type="button" data-toggle="collapse" data-target="#order-{{ $order->id }}-collapse" aria-expanded="false" aria-controls="collapse">Afficher</button>
            @if($order->isWaiting())
              <a href="{{ route('dashboard.orders.accept', $order) }}" class="btn btn-sm btn-outline-success">Accepter</a>
              <a href="{{ route('dashboard.orders.decline', $order) }}" class="btn btn-sm btn-outline-danger ml-2">Refuser</a>
              <form action="{{ route('dashboard.orders.cancel', $order) }}" method="POST" class="form-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-2">Annuler</button>
              </form>
            @endif
          </div>
        </div>
        <div class="collapse" id="order-{{ $order->id }}-collapse">
          <div class="card-body">
            @component('orders.components.cart', [
              'orderLines' => $order->lines,
              'discountName' => $order->discount ? $order->discount->name : null,
              'discountDescription' => $order->discount ? $order->discount->description : null,
              'deliveryPrice' => $order->deliveryPrice,
              'finalPrice' => $order->finalPrice,
              ])
            @endcomponent
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-6">
                @component('orders.components.address', [
                  'address1' => $order->address1,
                  'address2' => $order->address2,
                  'address3' => $order->address3,
                  'zip' => $order->zip,
                  'city' => $order->city
                  ])
                @endcomponent
              </div>
              <div class="col-md-6">
                @component('orders.components.customer', [
                  'firstName' => $order->customer->firstName,
                  'lastName' => $order->customer->lastName,
                  'email' => $order->customer->email,
                  'phone' => $order->customer->phone,
                  ])
                @endcomponent
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
