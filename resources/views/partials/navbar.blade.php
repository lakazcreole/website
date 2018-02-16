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
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">À propos <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">La carte</a>
                    </li>
                    <li class="nav-item">
                        <a v-on:click.prevent class="nav-link" href="#" @click="showContactModal = true">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="ml-2">
                <button class="btn btn-primary" type="submit">Commander</button>
            </div>
        </div>
    </div>
</nav>
