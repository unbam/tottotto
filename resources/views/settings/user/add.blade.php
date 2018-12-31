{{-- ユーザー追加画面 --}}
@extends('layouts.app')
@section('title', __('messages.add_value', ['value' => __('messages.user')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.add_value', ['value' => __('messages.user')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\UserController@list') }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <form action="{{ route('settings.user.insert') }}" method="post" class="form-horizontal">
        @csrf
        <div class="form-group row @if($errors->has('login_id')) has-error @endif">
            <label for="login_id" class="col-md-3 col-form-label text-md-right">{{ __('messages.login_id') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="login_id" name="login_id" value="{{ old('login_id') }}">
                @if($errors->has('login_id'))<span class="text-danger">{{ $errors->first('login_id') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('name')) has-error @endif">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('messages.name') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('email')) has-error @endif">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('messages.email') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @if($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span> @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="role" class="col-md-3 col-form-label text-md-right">{{ __('messages.role') }}</label>
            <div class="col-md-6">
                <select class="form-control-sm" id="role" name="role">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(old('role') == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row @if($errors->has('password')) has-error @endif">
            <label for="password" class="col-md-3 col-form-label text-md-right" >{{ __('messages.password') }}</label>
            <div class="col-md-6">
                <input type="password" class="form-control" id="password" name="password">
                @if($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('password-confirm')) has-error @endif">
            <label for="password-confirm" class="col-md-3 col-form-label text-md-right" >{{ __('messages.confirm_password') }}</label>
            <div class="col-md-6">
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
                @if($errors->has('password-confirm'))<span class="text-danger">{{ $errors->first('password-confirm') }}</span> @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 text-center">
                <input type="submit" name="register" value="{{ __('messages.register') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection