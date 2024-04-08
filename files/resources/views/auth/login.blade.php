@extends('layouts.app')

@section('content')
    <div class="header">
        <div class="left">
            <h1 class="title-page-nav" id="title-page">{{ __('Login') }}</h1>
        </div>
    </div>
    <div class="body-login">
        <div class="login">
            <img src="{{ asset('img/bg.jpg') }}" alt="">
            <h3>{{ __('Welcome Back!') }}</h3>
            <h2>{{ config('app.name') }}HR</h2>
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <input id="email" type="email" @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Enter your user') }}"
                    autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input id="password" type="password" @error('password') is-invalid @enderror" name="password" required
                    autocomplete="current-password" placeholder="{{ __('Enter your password') }}">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <button type="submit">{{ __('LOGIN') }}</button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>
@endsection
