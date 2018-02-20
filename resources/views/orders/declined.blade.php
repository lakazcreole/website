@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>Commande #{{ $id }} refusée</h1>
        <p>
            La commande de {{ $customerName }} a été refusée avec le message :
        </p>
        <blockquote class="blockquote">
            <p>{!! $declineMessage !!}</p>
        </blockquote>
        <h2>Informations</h2>
        <p>
            <ul>
                <li>Client : {{ $customerName }}</li>
                <li>Email : {{ $customerEmail }}</li>
                <li>Tél. : {{ $customerPhone }}</li>
                <li>Addresse : {{ $address }}</li>
                <li>Date : {{ $date }} à {{ $time }}</li>
            </ul>
        </p>
    </div>
@endsection
