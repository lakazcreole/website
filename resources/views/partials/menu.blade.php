<section class="menu my-5" id="la-carte">
  <div class="container">
    <h2 class="text-center mb-4">La carte</h2>
    <div class="flex flex-col md:flex-row">
      <div class="md:w-1/3 max-w-xs md:max-w-sm mx-4 mb-5 md:mb-0">
        @component('components.menu-card')
          @slot('image')
            <img src="{{ asset('/images/bouchons.jpg') }}" alt="Bouchons porc Réunion"/>
          @endslot
          @slot('title')
            Entrées
          @endslot
          <ul class="mb-3">
            <li class="mb-1">Bouchons</li>
            <li class="mb-1">Samoussas</li>
            <li class="mb-1">Bonbons piment</li>
          </ul>
          <p>Aussi disponibles en plateau apéritif.</p>
        @endcomponent
      </div>
      <div class="md:w-1/3 max-w-xs md:max-w-sm mx-4 mb-5 md:mb-0">
        @component('components.menu-card')
          @slot('image')
            <img src="{{ asset('/images/cari-poulet.jpg') }}" alt="Cari poulet Paris">
          @endslot
          @slot('title')
            Plats
          @endslot
          <ul class="mb-3">
            <li class="mb-1">Cari poulet</li>
            <li class="mb-1">Rougail saucisse</li>
            <li class="mb-1">Shop suey de légumes</li>
          </ul>
          <p>... et bien d'autres !</p>
        @endcomponent
      </div>
      <div class="md:w-1/3 max-w-xs md:max-w-sm mx-4 mb-5 md:mb-0">
        @component('components.menu-card')
          @slot('tag')
            Bientôt disponible
          @endslot
          @slot('image')
            <img src="./images/gateau-patate.jpg" alt="Gâteau patate maison">
          @endslot
          @slot('title')
            Desserts
          @endslot
          <ul class="mb-3">
            <li class="mb-1">Bonbons miel</li>
            <li class="mb-1">Gâteau patate</li>
            <li class="mb-1">Fruits exotiques</li>
          </ul>
          <p>Il reste toujours une place pour le dessert. 😉</p>
        @endcomponent
      </div>
    </div>
    <div class="text-center py-5">
      <a class="inline-block mx-auto mx-3 px-3 py-3 w-48 font-semibold rounded-full text-white bg-orange hover:bg-orange-light no-underline" href="{{ route('order') }}">Commander</a>
    </div>
  </div>
</section>
