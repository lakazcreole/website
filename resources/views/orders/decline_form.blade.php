@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="mb-3 d-flex">
            <h1 class="mb-0">Refuser la commande <small class="text-muted">#{{ $id }}</small></h1>
            <div class="ml-auto d-flex">
                <a href="{{ $acceptUrl }}" class="my-auto btn btn-sm btn-outline-success">Accepter</a>
            </div>
        </div>
        @component('components.dashboard.alert', ['type' => 'warning', 'closeable' => false])
          Vous êtes sur le point de refuser la commande de {{ $customerFirstName }}.
        @endcomponent
        @include('partials.dashboard.order')
        <h2>Mail</h2>
        @include('partials.dashboard.validation_errors')
        <form method="POST" action="{{ $postUrl }}" accept-charset="UTF-8">
            @csrf
            <div class="form-group">
                <label for="message">Personnaliser</label>
                <textarea class="form-control" name="message" id="message" rows="8">
Bonjour,

Je ne serai malheureusement pas en mesure d'assurer la livraison de votre commande prévue pour le {{ $date }} à {{ $time }}. En effet, je suis déjà engagée pour une prestation sur ce créneau.
Je vous remercie de votre commande et espère que vous recommanderez bientôt !

Cordialement,
                </textarea>
                <div>
                    <div class="collapse" id="collapse">
                        <small>
                            {{ config('app.name') }}
                        </small>
                    </div>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">
                        Ce mail sera complété par cette signature.
                    </button>
                </div>
            </div>
            <div class="form-group">
                Notifier le client par email :
                <div class="form-check form-check-inline ml-2">
                  <input class="form-check-input" type="radio" name="notify" id="enabled" value="1" checked>
                  <label class="form-check-label" for="enabled">Oui</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="notify" id="disabled" value="0">
                  <label class="form-check-label" for="disabled">Non</label>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-danger">Refuser</button>
        </form>
    </div>
@endsection
