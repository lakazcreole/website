<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/new.css') }}" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" sizes="196x196">

        <title>
            @section('title')
                {{ config('app.name') }}
            @show
        </title>
    </head>

    <body>
        <div id="app">
            @yield('content')
            @yield('modals')
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
        @env('production')
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114349707-1"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', 'UA-114349707-1');
            </script>
        @endenv
    </body>
</html>
