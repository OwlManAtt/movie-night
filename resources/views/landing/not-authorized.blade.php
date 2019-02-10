@extends('layouts.splash')

@section('content')
<div class="mt-4 text-light">
    <div class="alert alert-danger font-weight-bold" role="alert">
        Access Denied
    </div>

    <div>
        <small>
            <a href="{{ route('logout') }}" class="text-white-50">Logout {{ Auth::user()->nickname }}</a>
        </small>
    </div>
</div>
@endsection
