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
            <div class="gradient position-absolute w-100 h-100"></div>
            <div class="container">
                <h1 class="text-light pt-4 mb-3">Commande</h1>
                <div class="d-flex flex-row align-items-center mb-2">
                    <p class="text-dark mb-0 mr-4">
                        Je prépare chaque commande toute seule, il faut que toute commande doit être passée 24h à l'avance. Merci de votre compréhension.<br>
                        Pour toute demande particulière, contactez-moi directement !
                    </p>
                    <button class="btn btn-lg btn-outline-light ml-auto" @click="showContactModal = true">Contact</button>
                </div>
            </div>
        </div>
        <div class="order-manager container-fluid my-5 px-0">
            <order-manager></order-manager>
        </div>
    </section>
    @include('partials.footer')
@endsection
