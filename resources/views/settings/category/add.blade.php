{{-- カテゴリ追加画面 --}}
@extends('layouts.app')
@section('title', __('messages.add_value', ['value' => __('messages.category')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.add_value', ['value' => __('messages.category')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\CategoryController@list') }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <form action="{{ route('settings.category.insert') }}" method="post" class="form-horizontal">
        @csrf
        <div class="form-group row @if($errors->has('name')) has-error @endif">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('messages.category_name') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span> @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 text-center">
                <input type="submit" name="register" value="{{ __('messages.register') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection