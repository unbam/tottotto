{{-- ユーザー一覧画面 --}}
@extends('layouts.app')
@section('title', __('messages.list_value', ['value' => __('messages.user')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.list_value', ['value' => __('messages.user')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\UserController@add') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i>{{ __('messages.new_register') }}
        </a>
        <a href="{{ action('Settings\UserController@import') }}" class="btn btn-sm btn-outline-primary ml-2">
            <i class="fas fa-file-import"></i>{{ __('messages.user_import') }}
        </a>
    </div>
    <table class="table table-striped table-hover" id="confirm">
        <thead>
            <tr>
                <th>{{ __('messages.login_id') }}</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.role') }}</th>
                <th>{{ __('messages.created_date') }}</th>
                <th>{{ __('messages.updated_date') }}</th>
                <th class="col-del text-center">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <a href="{{ action('Settings\UserController@edit', $user->id) }}">{{ $user->login_id }}</a>
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>{{ $user->updated_at->format('Y-m-d') }}</td>
                <td class="col-del text-center">
                    <form action="{{ action('Settings\UserController@delete', $user->id) }}" method="POST">
                        @csrf
                        <input type="submit" value="×" class="btn btn-sm btn-outline-danger rounded-circle" v-on:click="confirm">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- ページネーション --}}
    <div class="row justify-content-md-center">
        {!! $users->render() !!}
    </div>
@endsection