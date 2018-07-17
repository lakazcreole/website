<div>
  {{-- <div class="banner">
  <div class="container d-flex align-items-baseline">
  La Kaz Créole lance sa campagne de financement participatif. Prenez part au projet et obtenez votre contrepartie !
  <a href="https://www.kisskissbankbank.com/fr/projects/la-kaz-creole-l-ile-de-la-reunion-a-portee-de-main" target="blank_" class="btn btn-sm btn-outline-light cta ml-auto">Participer</a>
  </div>
  </div> --}}
  <nav class="bg-grey-lightest text-lg">
    <div class="container mx-auto flex items-center">
      <a href="{{ route('home') }}">
        <img class="h-24" src="{{ asset('images/logo.png') }}" alt="Logo La Kaz Creéle">
      </a>
      <button class="block md:hidden border-2 border-grey-lighter px-2 py-2 rounded">
        <div class="w-4 border-b-2 border-black mb-1"></div>
        <div class="w-4 border-b-2 border-black mb-1"></div>
        <div class="w-4 border-b-2 border-black"></div>
      </button>
      <div class="ml-auto">
        <ul class="list-reset">
          <li class="inline mx-4">
            @if(Request::is('/'))
              <a class="text-grey-dark no-underline" href="#" @click.prevent="scrollToMenu">La carte</a>
            @endif
          </li>
          <li class="inline mx-4">
            <contact-button/>
          </li>
        </ul>
      </div>
      <div class="ml-3 text-center">
        <a class="inline-block mx-4 px-5 py-3 rounded-full text-white border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light no-underline" href="{{ route('order') }}">Commander</a>
      </div>
    </div>
  </nav>
</div>
