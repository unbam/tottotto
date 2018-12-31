{{-- ユーザー一括追加画面 --}}
@extends('layouts.app')
@section('title', __('messages.user_import'))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.user_import') }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\UserController@list') }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <div class="pt-3">
        <h5 class="pb-2">{{ __('messages.csv_import') }}</h5>
        <div class="card py-3">
            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group row @if($errors->has('user_csv')) has-error @endif">
                    <label for="user_csv" class="col-md-3 col-form-label text-md-right">{{ __('messages.csv_file') }}</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control" id="user_csv" name="user_csv">
                        @if($errors->has('user_csv'))<span class="text-danger">{{ $errors->first('user_csv') }}</span> @endif
                    </div>
                </div>
                <div class="form-group row @if($errors->has('user_csv')) has-error @endif">
                    <label for="user_csv" class="col-md-3 col-form-label text-md-right">{{ __('messages.char_code') }}</label>
                    <div class="col-md-6">
                        <select class="form-control form-control-sm selectpicker" id="code" name="code" style="width: 250px;" >
                            <option value="sjis" @if(old('code') == 'sjis') selected @endif>Shift_JIS</option>
                            <option value="utf8" @if(old('code') == 'utf8') selected @endif>UTF-8</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-4 text-center">
                        <input type="submit" name="confirm" value="{{ __('messages.confirm') }}" class="btn btn-primary btn-wide" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- CSVチェック内容表示 --}}
    @if(Session::has('users'))
        <form action="{{ route('settings.user.insertImport') }}" method="post" class="form-horizontal">
            @csrf
            <div class="check pt-5">
                <p>{{ __('messages.csv_check') }}</p>
                {{-- 登録可能なユーザがいない場合はエラーメッセージ表示 --}}
                @if(Session::has('is_all_error') && session('is_all_error') === 1)
                    <div class="alert alert-danger" id="error_message" role="alert">{{ __('messages.error_all_users') }}</div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('messages.row') }}</th>
                            <th>{{ __('messages.login_id') }}</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.role') }}</th>
                            <th>{{ __('messages.error_message') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(session('users') as $user)
                        <tr>
                            <td>
                                @if($user['is_error'] === 0)
                                    <span class="fas fa-check-circle is-error has-ok"></span>
                                @else
                                    <span class="fas fa-exclamation-triangle is-error has-ng"></span>
                                @endif
                            </td>
                            <td>{{ $user['row'] }}</td>
                            <td>{{ $user['login_id'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['role_name'] }}</td>
                            <td class="has-ng">{{ $user['error_message'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{-- 登録可能なユーザがいる場合はボタン表示 --}}
                @if(Session::has('is_all_error') && session('is_all_error') !== 1)
                    <div class="col-md-4 offset-md-4 text-center">
                        <button type="submit" class="btn btn-wide btn-outline-primary">
                            <i class="fas fa-check-circle is-error has-ok"></i>{{ __('messages.register_check_users') }}
                        </button>
                    </div>
                @endif
            </div>
        </form>
    @endif
    <div class="pt-5">
        <h5 class="pb-2">{{ __('messages.import_steps') }}</h5>
        <a href="/download/user_import.csv" class="user-import-link"><i class="fas fa-file"></i>{{ __('messages.csv_import_users') }}</a>
        <p>{{ __('messages.csv_download') }}</p>
        <div>
            <ul>
                <li>{{ __('messages.required') }}</li>
                <li>
                    {{ __('messages.role_level') }}<br>
                    {{ __('messages.role_level_value') }}
                </li>
            </ul>
        </div>
    </div>
@endsection