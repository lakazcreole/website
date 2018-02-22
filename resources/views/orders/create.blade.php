@extends('layouts.app')

@section('content')
    <section class="order">
        <div class="order-header py-4">
            <div class="container">
                <h1 class="text-light mb-3">Commande</h1>
                <div class="d-flex flex-row align-items-center mb-2">
                    <p class="text-dark mb-0 mr-4">
                        Je prépare chaque commande toute seule, il faut que toute commande doit être passée 24h à l'avance. Merci de votre compréhension.<br>
                        Pour toute demande particulière, contactez-moi directement !
                    </p>
                    <button class="btn btn-lg btn-outline-light ml-auto">Contact</button>
                </div>
            </div>
        </div>
        <div class="order-manager container-fluid px-0 pt-3">
            <order-manager></order-manager>
        </div>
    </section>
@endsection
