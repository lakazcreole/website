@extends('layouts.app')

@section('title')
    À propos -
    @parent
@endsection

@section('content')
    <div class="container">
        <div class="logo-wrapper">
            <img class="logo" src="{{ asset('img/logo.svg') }}" alt="logo La Kaz Creole">
        </div>
         <div class="row">
            <div class="col-sm-2 col-xs-12 text-center">
                <img class="portrait" src="{{ asset('images/laurane.jpg') }}">
            </div>
            <div class="col-sm-10 col-xs-12">
                <p class="text-justify">
                    Je suis Laurane Boullay, fondatrice de La Kaz Créole. Depuis 2017, ma mission est de vous faire découvrir à <strong>Paris</strong> les secrets de l'<strong>Ile de la Réunion</strong>, à travers une gastronomie exotique et savoureuse, faite maison. En attendant le <strong>food-truck</strong>, je vous propose déjà mes services de <strong>traiteur et livraison</strong> pour vos déjeuners, dîners et apéros.
                </p>
                <p class="text-justify">
                    Pour toute demande particulière contactez moi à l'adresse :
                    <a class="link" href="mailto:laurane@lakazcreole.fr">laurane@lakazcreole.fr</a>
                </p>
            </div>
        </div>
        <div class="socials">
            <p>Retrouvez La Kaz Créole sur les réseaux sociaux :</p>
            <div class="grow pic">
                <a class="image-link" href="https://www.instagram.com/lakazcreole/"><img class="logo-social" src="{{ asset('img/instagram.png') }}"/></a>
                <a class="image-link" href="https://www.facebook.com/kazcreole/"><img class="logo-social" src="{{ asset('img/facebook.png') }}"/></a>
            </div>
        </div>
        <contact-form></contact-form>
    </div>
@endsection
