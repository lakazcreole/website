<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" type="text/css">
        @yield('styles')

        <title>
            @section('title')
                Dashboard - {{ config('app.name') }}
            @show
        </title>
    </head>

    <body>
        <div id="app">
            @include('dashboard.partials.navbar')
            @yield('modals')
            @yield('content')
        </div>
        @yield('scripts')
        <script src="{{ mix('js/dashboard.js') }}"></script>
    </body>
</html>
