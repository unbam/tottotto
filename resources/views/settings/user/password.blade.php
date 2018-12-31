{{-- パスワード設定画面 --}}
@extends('layouts.app')
@section('title', __('messages.change_password'))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.change_password') }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ route(Request::is('personal/*') ? 'personal.user.edit' : 'settings.user.edit', $user->id) }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <form action="" method="post" class="form-horizontal">
        @csrf
        <div class="form-group row">
            <label for="login_id" class="col-md-3 col-form-label text-md-right">{{ __('messages.login_id') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="login_id" name="login_id" value="{{ $user->login_id }}" disabled>
            </div>
        </div>
        <div class="form-group row @if($errors->has('current_password')) has-error @endif">
            <label for="current-password" class="col-md-3 col-form-label text-md-right" >{{ __('messages.current_password') }}</label>
            <div class="col-md-6">
                <input type="password" class="form-control" id="current-password" name="current_password">
                @if($errors->has('current_password'))<span class="text-danger">{{ $errors->first('current_password') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('new_password')) has-error @endif">
            <label for="new-password" class="col-md-3 col-form-label text-md-right" >{{ __('messages.new_password') }}</label>
            <div class="col-md-6">
                <input type="password" class="form-control" id="new-password" name="new_password">
                @if($errors->has('new_password'))<span class="text-danger">{{ $errors->first('new_password') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('new_password_confirmation')) has-error @endif">
            <label for="new-password-confirm" class="col-md-3 col-form-label text-md-right" >{{ __('messages.confirm_password') }}</label>
            <div class="col-md-6">
                <input type="password" class="form-control" id="new-password-confirm" name="new_password_confirmation">
                @if($errors->has('new_password_confirmation'))<span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span> @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 text-center">
                <input type="submit" name="update" value="{{ __('messages.update') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection