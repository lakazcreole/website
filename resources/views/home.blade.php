@extends('layouts.app')

@push('modals')
    <contact-modal></contact-modal>
    <shop-closed-modal></shop-closed-modal>
@endpush

@section('content')
  <section class="h-120 relative font-sans">
    <div class="absolute h-full w-full" style="background-image: url('/images/header.jpg'); background-size: cover;"></div>
    <div class="bg-black opacity-25 absolute h-full w-full"></div>
    <div class="container mx-auto relative h-full flex">
      <div class="m-auto">
        <div class="text-center mb-10">
          <h1 class="font-title text-grey-lightest text-5xl md:text-6xl font-normal leading-tight mb-2 mx-3" style="text-shadow: 2px 2px 3px black">Commander réunionnais en quelques clics</h1>
          <p class="text-grey-lightest text-lg md:text-xl leading-tight mx-3" style="text-shadow: 2px 2px 3px black">Gastronomie réunionnaise disponible en traiteur et livraison à Paris.</p>
        </div>
        <div class="flex flex-wrap justify-center items-baseline text-center">
          <button class="mb-3 sm:mb-0 mx-4 px-3 py-3 w-50 rounded-full text-white border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light" @click="showShopClosedModal">Commander</button>
          {{--<a class="mb-3 sm:mb-0 mx-4 px-3 py-3 w-50 rounded-full text-white border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light no-underline" href="{{ route('order') }}">Commander</a>--}}
          <a class="mx-4 px-3 py-3 w-50 rounded-full text-white border-2 border-orange hover:border-orange-light hover:bg-orange-light no-underline" href="{{ asset('pdf/LaKazCreole.pdf') }}" target="_blank">Télécharger la carte</a>
        </div>
      </div>
    </div>
  </section>
  <section class="my-10 font-sans">
    <div class="container mx-auto">
      <div class="flex flex-col sm:flex-row flex-wrap justify-center mx-3">
        <div class="mb-5 sm:mb-0 flex w-full sm:w-1/4 lg:w-1/5">
          <img class="mx-auto sm:my-auto h-40 w-40 sm:h-32 sm:w-32 md:h-40 md:w-40 rounded-full" src="{{ asset('/images/laurane.jpg') }}">
        </div>
        <div class="max-w-xs sm:max-w-full w-full sm:w-3/4 lg:w-4/5 mx-auto px-3 sm:pl-5">
          <div class="intro bg-white p-4 rounded-lg">
            <div class="font-title text-3xl text-orange mb-4">Le mot de la fondatrice</div>
            <blockquote class="text-orange-darker leading-normal">
              <p class="text-justify">
                Je suis née à La Réunion et j'y ai grandi. Depuis 6 ans maintenant, je vis à Paris et La Réunion me manque. J'ai donc décidé il y a quelques mois d'amener un peu de l'Île Intense ici, à <strong>Paris</strong>. Je vous invite à découvrir ou redécouvrir une gastronomie authentique et savoureuse, faite maison. Les plats sont disponibles à la <strong>livraison pour vos déjeuners, dîners et apéros</strong>. Si vous voulez découvrir les samoussas, les bouchons, le cari poulet, le rougail saucisses et autres merveilles de l'<strong>Île de La Réunion</strong> vous êtes au bon endroit ! À bientôt.
              </p>
              <footer class="text-right">&mdash; Laurane</footer>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </section>
  @include('partials.menu')
@endsection
