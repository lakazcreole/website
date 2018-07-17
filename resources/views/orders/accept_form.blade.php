@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>Accepter la commande #{{ $id }}</h1>
        <p>
            Vous êtes sur le point d'accepter la commande de {{ $customerName }}.
        </p>
        <h2>Récapitulatif</h2>
        <p>
            Détail de la commande :
            <ul>
                @foreach($lines as $line)
                    <li>{{ $line->quantity }} {{ $line->product->name }} ({{ $line->totalPrice }} €)</li>
                @endforeach
            </ul>
            Soit un total de <strong>{{ $totalPrice }} €</strong>.
        </p>
        <h2>Informations</h2>
        <p>
            <ul>
                <li>Client : {{ $customerName }}</li>
                <li>Email : {{ $customerEmail }}</li>
                <li>Tél. : {{ $customerPhone }}</li>
                <li>Addresse : {{ "{$address1} {$address2} {$address3}" }}</li>
                <li>Date : {{ $date }} à {{ $time }}</li>
            </ul>
        </p>
        <h2>Mail</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ $postUrl }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="message">Personnaliser</label>
                <textarea class="form-control" name="message" id="message" rows="8">
Bonjour {{ $customerName }},

Vous avez réalisé une commande sur La Kaz Créole pour le {{ $date }} à {{ $time }}.
                </textarea>
                <div>
                    <div class="collapse" id="collapse">
                        <small>
                            # Récapitulatif de votre commande<br><br>
                            &lt;tableau récapitulatif&gt;<br><br>
                            Le paiement peut être réalisé en espèces, tickets restaurant ou Lydia. Le numéro de téléphone associé au compte Lydia est : 06 29 24 30 90.<br><br>
                            # Adresse de livraison<br><br>
                            {{ $address1 }}<br/>
                            {{ $address2 }}<br/>
                            {{ $address3 }}<br/>
                            {{ $zip }}<br/><br>
                            Bonne journée,<br/>
                            {{ config('app.name') }}
                        </small>
                    </div>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">
                        Ce mail sera complété par ce récapitulatif.
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
            <button type="submit" class="btn btn-lg btn-block btn-success">Accepter</button>
        </form>
    </div>
@endsection
