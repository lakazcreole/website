@extends('layouts.app')

@section('modals')
    @parent
    <contact-modal v-if="showContactModal" @close="showContactModal = false" :default-subject="subject" :default-message="message"></contact-modal>
@endsection

@section('content')
    <section class="promo position-relative">
        <div class="background position-absolute h-100 w-100"></div>
        <div class="overlay position-absolute h-100 w-100"></div>
        <div class="container position-relative h-100 d-flex">
            <div class="m-auto">
                <div class="text-center mb-4">
                    <h1>Vous êtes au bon endroit !</h1>
                    <p class="text-light">Gastronomie réunionnaise disponible en traiteur et livraison.</p>
                </div>
                <div class="d-flex flex-wrap justify-content-center">
                    <button class="btn btn-lg btn-primary m-2" @click="openOrder">Commander</button>
                    <a class="btn btn-lg btn-outline-primary m-2" href="{{ asset('pdf/LaKazCreole.pdf') }}" target="_blank">Télécharger la carte</a>
                </div>
            </div>
        </div>
    </section>
    <section class="intro my-5">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center">
                <img class="portrait my-auto" src="{{ asset('/images/laurane.jpg') }}">
                <div class="intro-text w-75">
                    <h2>Le mot de la fondatrice</h2>
                    <p class="text-justify">
                        Je suis Laurane Boullay, jeune réunionnaise titulaire d'un master entrepreneuriat. Je vous invite à découvrir sur <strong>Paris</strong> une gastronomie exotique et savoureuse, faite maison. Je vous propose déjà mes services de <strong>traiteur et livraison</strong> pour vos déjeuners, dîners et apéros. Samoussas, bouchons, cari poulet, rougail saucisse et autres merveilles de <strong>l'Île de la Réunion</strong> vous attendent. Alors, n'hésitez plus !
                    </p>
                </div>
            </div>
        </div>
    </section>
    @include('partials.menu')
@endsection
