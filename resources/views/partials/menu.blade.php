<section class="menu my-10  " id="la-carte">
  <div class="container mx-auto">
    <h2 class="text-center font-title text-orange text-5xl font-normal mb-8">La carte</h2>
    <div class="flex flex-col md:flex-row">
      <div class="sm:w-1/3 mx-auto sm:mx-4 mb-8 md:mb-0">
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
      <div class="sm:w-1/3 mx-auto sm:mx-4 mb-8 md:mb-0">
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
      <div class="sm:w-1/3 mx-auto sm:mx-4">
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
      </div>
        </ul>
        <p>Il reste toujours une place pour le dessert. 😉</p>
      @endcomponent
    </div>
    <div class="text-center mt-10">
      <a class="inline-block mx-auto mx-3 px-3 py-3 w-48 font-semibold rounded-full text-white bg-orange hover:bg-orange-light no-underline" href="{{ route('order') }}">Commander</a>
    </div>
  </div>
</section>
