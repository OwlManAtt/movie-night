@extends('layouts.shell')

@section('body')
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/"><i class="fas fa-film"></i> Movie Night</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#siteNav" aria-controls="siteNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="siteNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="/">Home</a>
            </li>

            <li class="nav-item {{ Request::is('event*') ? 'active' : '' }}">
                <a class="nav-link" href="/event">Schedule</a>
            </li>

            <li class="nav-item {{ Request::is('media*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('media.index') }}">Movies &amp; Shows</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            @guest
            <li class="nav-item mt-auto mb-auto">
                <a href="/login/discord">Login</a>
            </li>
            @endguest

            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->nickname }}</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/logout">Logout</a>
                </div>
            </li>

            <li class="nav-item mt-auto mb-auto">
                <img src="{{ Auth::user()->avatar_url }}" alt="" style="max-height: 40px;" class="rounded-circle border border-secondary">
            </li>
            @endauth
        </ul>
    </div>
</nav>

<main role="main" class="container">
    @yield('content')
</main>
@endsection
