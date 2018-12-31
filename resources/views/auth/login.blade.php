@extends('layouts.app')
@section('title', __('messages.login'))
@section('content')
<div class="container">
    <div class="row justify-content-center py-4">
        {{--<img src="{{ asset('img/48.svg') }}" width="48" height="48">--}}
        <img src="{{ asset('img/48.svg') }}" width="48" height="48">
        <h1>{{ config('app.name', 'Laravel') }}</h1>
    </div>
    <div class="row justify-content-center py-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('messages.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="login_id" class="col-md-4 col-form-label text-md-right">{{ __('messages.login_id') }}</label>

                            <div class="col-md-6">
                                <input id="login_id" type="text" class="form-control{{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id" value="{{ old('login_id') }}" required autofocus>

                                @if ($errors->has('login_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('login_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('messages.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.login') }}
                                </button>

                                {{--<a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('messages.forget_password') }}
                                </a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
