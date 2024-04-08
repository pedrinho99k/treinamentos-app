@extends('layouts.app')

@section('content')
    <div class="header">
        <div class="left">
            <h1 class="title-page-nav" id="title-page">{{ __('Register') }}</h1>
        </div>
    </div>
    <div class="bottom-data">
        <form method="POST" action="{{ route('register') }}" class="form-content">
            @csrf
            <div class="coluna-12">
                <label for="name" class="label-input">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-input @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="coluna-12">
                <label for="email" class="label-input">{{ __('Email Address') }}</label>

                <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="coluna-12">
                <label for="password" class="label-input">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-input @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="coluna-12">
                <label for="password-confirm" class="label-input">{{ __('Confirm Password') }}</label>

                <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required
                    autocomplete="new-password">
            </div>

            <div class="coluna-12">
                <button type="submit" class="button button-primary">
                    {{ __('Register') }}
                </button>
            </div>
    </div>
@endsection
