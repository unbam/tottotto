{{-- ユーザー変更画面 --}}
@extends('layouts.app')
@section('title', __('messages.edit_value', ['value' => __('messages.user')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.edit_value', ['value' => __('messages.user')]) }}</h3>
    </div>
    <div class="py-3">
        <div class="row">
            <div class="col-md-2 mr-auto">
                @if(Request::is('settings/*'))
                    {{-- 設定用 --}}
                    <a href="{{ action('Settings\UserController@list') }}">
                        <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
                    </a>
                @endif
            </div>
            <div class="col-md-5 ml-auto text-md-right">
                <a href="{{ route(Request::is('personal/*') ? 'personal.user.editPassword' : 'settings.user.editPassword', $user->id) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-key"></i>{{ __('messages.change_password') }}
                </a>
                <form action="{{ action('Settings\UserController@delete', $user->id) }}" method="POST" class="d-inline ml-2">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" v-on:click="confirm">
                        <i class="fas fa-trash-alt"></i>{{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal">
        @csrf
        <div class="form-group row @if($errors->has('login_id')) has-error @endif">
            <label for="login_id" class="col-md-3 col-form-label text-md-right">{{ __('messages.login_id') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="login_id" name="login_id" value="{{ old('login_id', $user->login_id) }}">
                @if($errors->has('login_id'))<span class="text-danger">{{ $errors->first('login_id') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('name')) has-error @endif">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('messages.name') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('email')) has-error @endif">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('messages.email') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                @if($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span> @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="role" class="col-md-3 col-form-label text-md-right">{{ __('messages.role') }}</label>
            <div class="col-md-6">
                <select class="form-control-sm" id="role" name="role" @if(Auth::user()->role->level <= 10) disabled @endif>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(old('role', $user->role_id) == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 text-center">
                <input type="submit" name="update" value="{{ __('messages.update') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection