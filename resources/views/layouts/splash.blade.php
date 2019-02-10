@extends('layouts.shell')

@section('body-class', 'bg-dark d-flex align-items-center')

@section('body')
<div class="mx-auto text-center bg-secondary p-3 rounded shadow-lg">
    <span class="fa-stack fa-7x">
        <i class="fas fa-square fa-stack-2x"></i>
        <i class="fas fa-film fa-stack-1x fa-inverse"></i>
    </span>

    <div class="text-light mt-1">
        <h2>Movie Night</h2>
    </div>

    <hr>

    @yield('content')
</div>
@endsection
