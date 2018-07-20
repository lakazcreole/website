<header class="sticky pin-t z-10 font-main">
  <div style="-webkit-box-shadow: 0 2px 3px #ab5c0c; box-shadow: 0 2px 3px #ab5c0c">
    {{-- <div class="banner">
    <div class="container d-flex align-items-baseline">
    La Kaz Créole lance sa campagne de financement participatif. Prenez part au projet et obtenez votre contrepartie !
    <a href="https://www.kisskissbankbank.com/fr/projects/la-kaz-creole-l-ile-de-la-reunion-a-portee-de-main" target="blank_" class="btn btn-sm btn-outline-light cta ml-auto">Participer</a>
    </div>
    </div> --}}
    <nav class="text-lg relative">
      <div class="bg-grey-lightest">
        <div class="container mx-auto flex items-center">
          <a href="{{ route('home') }}" class="mr-auto">
            <img class="h-24" src="{{ asset('images/logo.png') }}" alt="Logo La Kaz Creéle">
          </a>
          <button class="block sm:hidden border border-orange-dark px-2 py-2 rounded mr-3" @click="showNav = !showNav">
            <div class="w-6 border-b-2 border-orange-dark mb-1"></div>
            <div class="w-6 border-b-2 border-orange-dark mb-1"></div>
            <div class="w-6 border-b-2 border-orange-dark"></div>
          </button>
          <ul class="hidden sm:block list-reset">
            @if(Request::is('/'))
              <li class="inline mx-4">
                <a class="text-grey-dark no-underline" href="#" @click.prevent="scrollToMenu">La carte</a>
              </li>
            @endif
            <li class="inline mx-4">
              <contact-button/>
            </li>
            <li class="inline mx-4">
              <a class="inline-block px-5 py-3 rounded-full text-white border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light no-underline" href="{{ route('order') }}">Commander</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="absolute w-full overflow-hidden">
        <transition name="slide" enter-active-class="slideInDown" leave-active-class="slideOutUp">
          <ul v-show="showNav" class="p-3 bg-grey-lightest list-reset">
            @if(Request::is('/'))
              <li class="mb-4">
                <a class="text-grey-dark no-underline" href="#" @click.prevent="scrollToMenu">La carte</a>
              </li>
            @endif
            <li class="mb-4">
              <contact-button/>
            </li>
            <li class="">
              <a class="text-grey-dark no-underline" href="{{ route('order') }}">Commander</a>
            </li>
          </ul>
        </transition>
      </div>
    </nav>
  </div>
</header>
