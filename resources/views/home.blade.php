@extends('layouts.app')

@section('modals')
  @parent
  <contact-modal/>
@endsection

@section('content')
{{--   <header v-sticky="{ zIndex: 1020, stickyTop: 0 }">
    @include('partials.navbar')
  </header>
  <section class="promo position-relative">
    <div class="background position-absolute h-100 w-100"></div>
    <div class="overlay position-absolute h-100 w-100"></div>
    <div class="container position-relative h-100 d-flex">
      <div class="m-auto">
        <div class="text-center mb-4">
          <h1>Commander réunionnais en quelques clics</h1>
          <p class="text-light">Gastronomie réunionnaise disponible en traiteur et livraison à Paris.</p>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
          <a class="btn btn-rounded btn-lg btn-primary m-2" href="{{ route('order') }}">Commander</a>
          <a class="btn btn-rounded btn-lg btn-outline-primary m-2" href="{{ asset('pdf/LaKazCreole.pdf') }}" target="_blank">Télécharger la carte</a>
        </div>
      </div>
    </div>
  </section> --}}
  <section class="my-10">
    <div class="container mx-auto">
      <div class="flex flex-col sm:flex-row flex-wrap justify-content-center mx-3">
        <div class="mb-5 sm:mb-0 flex w-full sm:w-1/4 lg:w-1/5">
          <img class="mx-auto sm:my-auto h-40 w-40 sm:h-32 sm:w-32 md:h-40 md:w-40 rounded-full" src="{{ asset('/images/laurane.jpg') }}">
        </div>
        <div class="max-w-xs sm:max-w-full w-full sm:w-3/4 lg:w-4/5 mx-auto px-3 sm:pl-5">
          <div class="intro bg-white p-4 rounded-lg">
            <div class="font-title text-3xl text-orange mb-4">Le mot de la fondatrice</div>
            <blockquote class="text-orange-darker leading-normal">
              <p class="text-justify">
                Je suis née à la Réunion et j'y ai grandi. Depuis 6 ans maintenant, je vis à Paris et la Réunion me manque. J'ai donc décidé il y a quelques mois d'amener un peu de l'Île Intense ici, à <strong>Paris</strong>. Je vous invite à découvrir ou redécouvrir une gastronomie authentique et savoureuse, faite maison. Les plats sont disponibles à la <strong>livraison pour vos déjeuners, dîners et apéros</strong>. Si vous voulez découvrir les samoussas, les bouchons, le cari poulet, le rougail saucisses et autres merveilles de l'<strong>Île de la Réunion</strong> vous êtes au bon endroit ! À bientôt.
              </p>
              <footer class="text-right">&mdash; Laurane</footer>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </section>
  @include('partials.menu')
  @include('partials.footer')
@endsection
