@extends('layouts.login')

@section('content')
<div class="container">
    <div class="login-wrap">
        <div class="login-content">
            <div class="login-logo">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('images/icon/logo-blue.png') }}" alt="{{ config('app.name') }}">
                </a>
            </div>
            <div class="login-form text-center">
                <hr/>
                <p class="text-bold">Your account is waiting for our administrator approval.</p>
                <p class="text-bold">Please check later.</p>
                <p class="text-bold"><a href="{{ route('login') }}" class="btn btn-link">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
@endsection