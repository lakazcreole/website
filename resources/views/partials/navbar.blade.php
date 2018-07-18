<div style="-webkit-box-shadow: 0 2px 3px #ab5c0c; box-shadow: 0 2px 3px #ab5c0c">
  {{-- <div class="banner">
  <div class="container d-flex align-items-baseline">
  La Kaz Créole lance sa campagne de financement participatif. Prenez part au projet et obtenez votre contrepartie !
  <a href="https://www.kisskissbankbank.com/fr/projects/la-kaz-creole-l-ile-de-la-reunion-a-portee-de-main" target="blank_" class="btn btn-sm btn-outline-light cta ml-auto">Participer</a>
  </div>
  </div> --}}
  <nav class="text-lg">
    <div class="bg-grey-lightest">
      <div class="container mx-auto flex">
        <a href="{{ route('home') }}">
          <img class="h-24" src="{{ asset('images/logo.png') }}" alt="Logo La Kaz Creéle">
        </a>
        <div class="flex ml-auto">
          <button class="block sm:hidden border border-orange-dark px-2 py-2 rounded my-auto mr-3" @click="showNav = !showNav">
            <div class="w-6 border-b-2 border-orange-dark mb-1"></div>
            <div class="w-6 border-b-2 border-orange-dark mb-1"></div>
            <div class="w-6 border-b-2 border-orange-dark"></div>
          </button>
          <div class="hidden sm:flex h-full items-center">
            <ul class="list-reset">
              @if(Request::is('/'))
                <li class="inline mx-4">
                  <a class="text-grey-dark no-underline" href="#" @click.prevent="scrollToMenu">La carte</a>
                </li>
              @endif
              <li class="inline mx-4">
                <contact-button/>
              </li>
            </ul>
            <div class="ml-3 text-center inline-block">
              <a class="inline-block mx-4 px-5 py-3 rounded-full text-white border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light no-underline" href="{{ route('order') }}">Commander</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="overflow-hidden bg-grey-lightest">
      <transition
        name="slide"
        enter-active-class="slideInDown"
        leave-active-class="slideOutUp"
      >
        <div v-show="showNav" class="block md:hidden container mx-auto">
          <ul class="list-reset px-3 py-2">
            @if(Request::is('/'))
              <li class="py-2">
                <a class="text-grey-dark no-underline" href="#" @click.prevent="scrollToMenu">La carte</a>
              </li>
            @endif
            <li class="py-2">
              <contact-button/>
            </li>
            <li class="py-2">
              <a class="text-grey-dark no-underline" href="{{ route('order') }}">Commander</a>
            </li>
          </ul>
        </div>
      </transition>
    </div>
  </nav>
</div>
