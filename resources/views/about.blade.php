<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

        <title>À propos - La Kaz Créole</title>
    </head>

    <body>
        <div id="app">
            <div class="container">
                <div class="logo-wrapper">
                    <img class="logo" src="{{ asset('img/logo.svg') }}" alt="logo La Kaz Creole">
                </div>
                 <div class="row">
                    <div class="col-sm-2 col-xs-12 text-center">
                        <img class="portrait" src="{{ asset('images/laurane.jpg') }}">
                    </div>
                    <div class="col-sm-10 col-xs-12">
                        <p class="text-justify">
                            Je suis Laurane Boullay, fondatrice de La Kaz Créole. Depuis 2017, ma mission est de vous faire découvrir à <strong>Paris</strong> les secrets de l'<strong>Ile de la Réunion</strong>, à travers une gastronomie exotique et savoureuse, faite maison. En attendant le <strong>food-truck</strong>, je vous propose déjà mes services de <strong>traiteur et livraison</strong> pour vos déjeuners, dîners et apéros.
                        </p>
                        <p class="text-justify">
                            Pour toute demande particulière contactez moi à l'adresse :
                            <a class="link" href="mailto:laurane@lakazcreole.fr">laurane@lakazcreole.fr</a>
                        </p>
                    </div>
                </div>
                <div class="socials">
                    <p>Retrouvez La Kaz Créole sur les réseaux sociaux :</p>
                    <div class="grow pic">
                        <a class="image-link" href="https://www.instagram.com/lakazcreole/"><img class="logo-social" src="{{ asset('img/instagram.png') }}"/></a>
                        <a class="image-link" href="https://www.facebook.com/kazcreole/"><img class="logo-social" src="{{ asset('img/facebook.png') }}"/></a>
                    </div>
                </div>
                <div>
                    <p class="text-center">Pour suivre le projet et recevoir les nouveautés inscrivez-vous à la newsletter !</p>
                    <form v-on:submit.prevent="onSubmit">
                        <label for="name">Nom :</label>
                        <input type="text" id="name"/>
                        <label for="email">E-mail :</label>
                        <input type="email" id="email" />
                        <label for="object">Objet :</label>
                        <input type="text" id="object"/>
                        <label for="message">Message :</label>
                        <textarea name="comment" id="message">Enter text here...</textarea>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
            <div class="gradiant-background"></div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
