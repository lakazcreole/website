@if(Auth::check() && Auth::user()->admin)
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light border-bottom border-dark mb-3">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.orders.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.orders.index') }}">Commandes</a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.products.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.products.index') }}">Produits</a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.offers.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.offers.index') }}">Offres</a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.discounts.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.discounts.index') }}">Réductions</a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.promo_codes.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.promo-codes.index') }}">Codes promo</a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.subscriptions.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.subscriptions.index') }}">Newsletter</a>
        </li>
        <li class="nav-item {{ Route::currentRouteName() === 'dashboard.contacts.index' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.contacts.index') }}">Contacts</a>
        </li>
        <li class="nav- {{ Route::currentRouteName() === 'dashboard.logs' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard.logs') }}">Logs</a>
        </li>
      </ul>
      <div class="navbar-nav">
        <a class="nav-link" href="{{ route('home') }}" target="_blank">
          Site
          <i class="material-icons" style="font-size: 0.9rem; vertical-align: middle;">open_in_new</i>
        </a>
        <a class="nav-link" href="https://docs.google.com/spreadsheets/d/1Bt-5V-Gp-d4asQOb6XLwaTbxZTJEHzoCRtlBlZ5rRa8/edit?usp=sharing" target="_blank">
          Stocks
          <i class="material-icons" style="font-size: 0.9rem; vertical-align: middle;">open_in_new</i>
        </a>
        <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="material-icons">input</i>
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST">
          @csrf
        </form>
      </div>
{{--       <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> --}}
    </div>
  </div>
</nav>
@endif
