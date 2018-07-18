@extends('layouts.app')

@push('modals')
  <contact-modal/>
@endpush

@section('content')
  <section>
    <div class="relative h-32">
      <div class="absolute z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"></div>
      <div class="absolute z-0 bg-black opacity-25 w-full h-full"></div>
      <div class="container mx-auto relative h-full text-grey-lightest">
        <h1 class="">Commande</h1>
        <p class="">
          Chaque commande est préparée par mes soins de l'achat des marchandises à la livraison chez vous. Il faut donc commander <strong class="text-orange">24h à l'avance</strong> pour que je puisse vous servir dans les meilleures conditions. Merci d'avance pour votre compréhension.<br>
          Pour toute demande particulière, <a class="text-grey-lightest" href="#" @click.prevent="$modal.show('contact-modal')">contactez-moi directement</a> !
        </p>
      </div>
    </div>
    <div class="order-manager container-fluid my-5 px-0">
      <order-manager></order-manager>
    </div>
  </section>
@endsection
