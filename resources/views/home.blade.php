@extends('layouts.app')

@section('modals')
  @parent
  <contact-modal/>
@endsection

@section('content')
  <header v-sticky="{ zIndex: 1020, stickyTop: 0 }">
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
  </section>
  <section class="intro my-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center">
          <img class="portrait my-auto" src="{{ asset('/images/laurane.jpg') }}">
          <div class="intro-text w-75">
            <h2>Le mot de la fondatrice</h2>
            <blockquote class="blockquote mb-0">
              <p class="text-justify">
                Je suis née à la Réunion et j'y ai grandi. Depuis 6 ans maintenant, je vis à Paris et la Réunion me manque. J'ai donc décidé il y a quelques mois d'amener un peu de l'Île Intense ici, à <strong>Paris</strong>. Je vous invite à découvrir ou redécouvrir une gastronomie authentique et savoureuse, faite maison. Les plats sont disponibles à la <strong>livraison pour vos déjeuners, dîners et apéros</strong>. Si vous voulez découvrir les samoussas, les bouchons, le cari poulet, le rougail saucisses et autres merveilles de l'<strong>Île de la Réunion</strong> vous êtes au bon endroit ! À bientôt.
              </p>
              <footer class="blockquote-footer text-right">Laurane</footer>
            </blockquote>
{{--             <p class="text-justify">
              Je suis Laurane Boullay, jeune réunionnaise titulaire d'un master entrepreneuriat. Je vous invite à découvrir sur <strong>Paris</strong> une gastronomie exotique et savoureuse, faite maison. Je vous propose déjà mes services de <strong>traiteur et livraison</strong> pour vos déjeuners, dîners et apéros. Samoussas, bouchons, cari poulet, rougail saucisse et autres merveilles de <strong>l'Île de la Réunion</strong> vous attendent. Alors, n'hésitez plus !
            </p> --}}
          </div>
        </div>
    </div>
  </section>
  @include('partials.menu')
  @include('partials.footer')
@endsection
