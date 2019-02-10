<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Movie Night event manager">
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
        <meta name="csrf-token" content="{{ @csrf_token() }}">

        <title>Movie Night</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    </head>

    <body class="@yield('body-class')">
        @yield('body')

        <script src="{{ mix('/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
