@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>Commande #{{ $id }} acceptée</h1>
        <p>
            La commande de {{ $customerName }} a été acceptée avec succès.
        </p>
        <h2>Récapitulatif</h2>
        <p>
            Détail de la commande :
            <ul>
                @foreach($lines as $line)
                    <li>{{ $line->quantity }} {{ $line->product->pieces > 1 ? "portion(s) de {$line->product->pieces}" : "" }} {{ $line->product->name }} ({{ $line->totalPrice }} €)</li>
                @endforeach
            </ul>
            Soit un total de <strong>{{ $totalProductsPrice }} €</strong>.
        </p>
        <h2>Informations</h2>
        <p>
            <ul>
                <li>Client : {{ $customerName }}</li>
                <li>Email : {{ $customerEmail }}</li>
                <li>Tél. : {{ $customerPhone }}</li>
                <li>Addresse : {{ $address }}</li>
                <li>Code postal : {{ $zip }}</li>
                <li>Date : {{ $date }} à {{ $time }}</li>
            </ul>
        </p>
    </div>
@endsection
