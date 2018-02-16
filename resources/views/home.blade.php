@extends('layouts.app')

@section('modals')
    @parent
    <contact-modal v-if="showContactModal" @close="showContactModal = false"></contact-modal>
@endsection

@section('content')
    <header>
        <div class="sticky-top">
            @include('partials.navbar')
        </div>
        <div class="promo">
            <div class="container h-100 d-flex">
                <div class="m-auto">
                    <h1 class="text-center">Vous êtes au bon endroit !</h1>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <section class="intro">
            <div class="d-flex">
                <img class="portrait" src="{{ asset('/images/laurane.jpg') }}">
                <div class="ml-4 my-auto">
                    <h2>Le mot de la fondatrice</h2>
                    <p class="text-justify">
                        Je suis Laurane Boullay, jeune réunionnaise titulaire d'un master entrepreneuriat. Je vous invite à découvrir sur <strong>Paris</strong> une gastronomie exotique et savoureuse, faite maison. Je vous propose déjà mes services de <strong>traiteur et livraison</strong> pour vos déjeuners, dîners et apéros. Samoussas, bouchons, cari poulet, rougail saucisse et autres merveilles de <strong>l'Île de la Réunion</strong> vous attendez. Alors, n'hésitez plus !
                    </p>
                </div>
            </div>
        </section>
        @include('partials.menu')
{{--         <section class="newsletter">
            <p class="text-center">Pour suivre le projet et recevoir nos actualités, inscrivez-vous à la newsletter !</p>
            <div class="d-flex">
                <form v-on:submit.prevent="onSubmit" class="form-inline mx-auto">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" placeholder="Entrez votre email"/>
                    </div>
                    <button type="submit" class="btn btn-primary ml-2">Je m'inscris</button>
                </form>
            </div>
        </section> --}}
    </div>
    @include('partials.footer')
@endsection
