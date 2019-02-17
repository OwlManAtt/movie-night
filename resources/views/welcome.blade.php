@extends('layouts.site')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">{{ $next->title }}</h1>
        <p>{{ $next->plot_summary }}</p>
        <p><a class="btn btn-primary btn-lg pl-3" href="{{  $next->details_url }}" role="button">Details »</a></p>
    </div>
</div>

<div class="row">
    @foreach ($future as $media)
    <div class="col-md-4">
        <h2>{{ $media->title }}</h2>
        <p>{{  $media->plot_summary }}</p>
        <p><a class="btn btn-secondary" href="{{ $media->details_url }}" role="button">Details »</a></p>
    </div>
    @endforeach
</div>
@endsection
