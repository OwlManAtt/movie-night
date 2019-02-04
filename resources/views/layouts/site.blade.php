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

    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="/"><i class="fas fa-film"></i> Movie Night</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Schedule</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('media.index') }}">Movies &amp; Shows</a>
                    </li>
                </ul>

                @guest
                <a href="/login/discord">Login</a>
                @endguest

                @auth
                {{ Auth::user()->nickname }}
                @endauth
            </div>
        </nav>

        <main role="main" class="container">
            @yield('content')
        </main>

        <script src="{{ mix('/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
