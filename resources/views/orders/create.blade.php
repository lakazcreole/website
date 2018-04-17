@extends('layouts.app')

@section('modals')
    @parent
    <contact-modal v-if="showContactModal" @close="showContactModal = false" :default-subject="subject" :default-message="message"></contact-modal>
@endsection

@section('content')
    <header v-sticky="{ zIndex: 1020, stickyTop: 0 }">
        @include('partials.navbar')
    </header>
    <section class="order">
        <div class="order-header pb-4 position-relative">
            <div class="background position-absolute w-100 h-100"></div>
            <div class="overlay position-absolute w-100 h-100"></div>
            <div class="container">
                <h1 class="text-light pt-4 mb-3">Commande</h1>
                <p class="text-light">
                    Chaque commande est préparée par mes soins de l'achat des marchandises à la livraison chez vous. Il faut donc commander <strong>24h à l'avance</strong> pour que je puisse vous servir dans les meilleures conditions. Merci d'avance pour votre compréhension.<br>
                    Pour toute demande particulière, <a class="link" href="#" @click.prevent="showContactModal = true">contactez-moi directement</a> !
                </p>
            </div>
        </div>
        <div class="order-manager container-fluid my-5 px-0">
            <order-manager></order-manager>
        </div>
    </section>
    @include('partials.footer')
@endsection
