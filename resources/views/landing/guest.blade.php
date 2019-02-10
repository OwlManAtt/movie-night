@extends('layouts.splash')

@section('content')
<div class="mt-4">
    <a href="{{ route('oauth-start') }}" class="btn btn-lg btn-discord shadow-sm">
        <i class="fab fa-discord pr-2"></i>
        Authorize via Discord
    </a>
</div>
@endsection
