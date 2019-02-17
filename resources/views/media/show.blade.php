@extends('layouts.site')

@section('content')
<div class="row">
    <div class="col-3">
        <img src="{{ $media->poster_url }}" alt="{{ $media->title }} Poster" class="img-fluid rounded shadow-sm">
    </div>

    <div class="col-9">
        <div class="row border-bottom mb-3">
            <div class="col-10">
                <h2><i class="fas {{ $type === 'movie' ? 'fa-film' : 'fa-tv' }} text-muted"></i> {{ $media->title }}</h2>
            </div>

            <div class="col-2 text-right">
                <span class="h2"><i class="fas fa-star text-warning"></i> {{ sprintf('%01.1f', $media->imdb_rating) }}</span> <sup><small class="text-muted">/ 10</small></sup>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                {{ $media->plot_summary }}
            </div>
        </div>

        @if($has_episodes === true)
        <div class="row mt-3">
            <div class="col-12">
                <h4>Episodes</h4>
                {!! $dataTable->table() !!}
            </div>
        </div>
        @endif

    </div>
</div>

<div class="row mt-3">
    <div class="col-3 h4">
        <dl class="row">
            <dt class="col-6">Released</dt>
            <dd class="col-6 text-right">{{  $media->year_released }}</dd>

            <dt class="col-6">Viewed</dt>
            <dd class="col-6 text-right"><em>Never</em></dd>

            <dt class="col-6">HorribleScore</dt>
            <dd class="col-6 text-right"><em>Unknown</em></dd>
        </dl>
    </div>
</div>
@endsection

@push('scripts')
    @if($has_episodes === true)
    {!! $dataTable->scripts() !!}
    @endif
@endpush
