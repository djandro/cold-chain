@extends('layouts.login')

@section('content')
<div class="container">
    <div class="login-wrap">
        <div class="login-content">
            <div class="login-logo">
                <a href="#">
                    <img src="{{ asset('images/icon/logo-blue.png') }}" alt="{{ config('app.name') }}">
                </a>
            </div>
            <div class="login-form">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="au-input au-input--full form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@example.com" autofocus>

                        @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input class="au-input au-input--full form-control{{ $errors->has('password') ? ' is-invalid' : '' }} au-input au-input--full" type="password" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="login-checkbox">
                        <label for="remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                        </label>
                        @if (Route::has('password.request'))
                        <label>
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </label>
                        @endif
                    </div>

                    @if (session('status'))
                    <div class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                    @endif

                    <button type="submit" class="au-btn au-btn--block au-btn--green m-b-20">
                        {{ __('Login') }}
                    </button>
                </form>
                <div class="register-link">
                    <p>
                        Don't you have account?
                        <a href="{{ route('register') }}">Sign Up Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
