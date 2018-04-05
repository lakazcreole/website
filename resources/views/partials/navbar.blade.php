<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="logo" src="{{ asset('images/logo.png') }}" alt="logo La Kaz Creole">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="ml-auto">
                <ul class="navbar-nav mx-2">
{{--                     <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="#">À propos {!! Request::is('/') ? '<span class="sr-only">(current)</span>' : '' !!}</a>
                    </li> --}}
                    <li class="nav-item">
                        @if(Request::is('/'))
                            <a class="nav-link" href="#" @click.prevent="scrollToMenu">La carte</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click.prevent="showContactModal = true">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="ml-2">
                <a class="btn btn-rounded btn-lg btn-primary" href="{{ route('order') }}">Commander</a>
            </div>
        </div>
    </div>
</nav>
