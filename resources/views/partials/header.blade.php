<header class="sticky pin-t z-50 font-main">
  <div style="-webkit-box-shadow: 0 2px 3px #ab5c0c; box-shadow: 0 2px 3px #ab5c0c">
    <nav class="sm:text-lg relative">
      <div class="bg-grey-lightest">
        <div class="container mx-auto flex items-center">
          <a href="{{ route('home') }}" class="mr-auto">
            <img class="h-24" src="{{ asset('images/logo.png') }}" alt="Logo La Kaz Creéle">
          </a>
{{--           <button class="block sm:hidden border border-orange-dark px-2 py-2 rounded mr-3" @click="showNav = !showNav">
            <div class="w-6 border-b-2 border-orange-dark mb-1"></div>
            <div class="w-6 border-b-2 border-orange-dark mb-1"></div>
            <div class="w-6 border-b-2 border-orange-dark"></div>
          </button> --}}
          <ul class="list-reset flex items-center">
            @if(Request::is('/'))
              <li class="hidden sm:inline mr-4">
                <a class="text-grey-dark no-underline" href="#" @click.prevent="scrollToMenu">La carte</a>
              </li>
            @endif
            <li class="inline mr-4">
              <contact-button/>
            </li>
            <li class="inline mr-3">
              <order-button url="{{ route('order') }}" :order="{{ Request::is('commande') ? 'true' : 'false' }}"/>
            </li>
          </ul>
        </div>
      </div>
{{--       <div class="absolute w-full overflow-hidden">
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
      </div> --}}
    </nav>
  </div>
</header>
