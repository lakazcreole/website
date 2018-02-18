@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panier</h1>
        <div class="card">
{{--             <div class="card-header">
                Panier
            </div> --}}
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Samoussas
                    <span>3,5 €</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Samoussas
                    <span>3,5 €</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Samoussas
                    <span>3,5 €</span>
                </li>
            </ul>
            <div class="card-footer d-flex justify-content-between">
                <strong>Total</strong>
                <strong>
                    20 €
                </strong>
            </div>
        </div>
    </div>
@endsection
