{{-- タグ追加画面 --}}
@extends('layouts.app')
@section('title', __('messages.add_value', ['value' => __('messages.tag')]))
@section('scripts')
    <script src="{{ asset('js/tag.js') }}" defer></script>
@endsection
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.add_value', ['value' => __('messages.tag')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\TagController@list') }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <form action="{{ route('settings.tag.insert') }}" method="post" class="form-horizontal" id="tag-page">
        @csrf
        <div class="form-group row @if($errors->has('name')) has-error @endif">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('messages.tag_name') }}</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" ref="text" data-value="{{ old('name', 'Tag') }}" v-on:input="changeTagText">
                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('color')) has-error @endif">
            <label for="color" class="col-md-3 col-form-label text-md-right">{{ __('messages.font_color') }}</label>
            <div class="col-md-2">
                <input type="color" class="form-control" id="color" name="color" value="{{ old('color', '#FFFFFF') }}" ref="color" data-value="{{ old('color', '#FFFFFF') }}" v-on:change="changeTagColor">
                @if($errors->has('color'))<span class="text-danger">{{ $errors->first('color') }}</span> @endif
            </div>
        </div>
        <div class="form-group row @if($errors->has('background_color')) has-error @endif">
            <label for="color" class="col-md-3 col-form-label text-md-right">{{ __('messages.background_color') }}</label>
            <div class="col-md-2">
                <input type="color" class="form-control" id="background_color" name="background_color" value="{{ old('background_color', '#000000') }}" ref="bgColor" data-value="{{ old('background_color', '#000000') }}" v-on:change="changeTagBackgroundColor">
                @if($errors->has('background_color'))<span class="text-danger">{{ $errors->first('background_color') }}</span> @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="color" class="col-md-3 col-form-label text-md-right">{{ __('messages.sample') }}</label>
            <div class="col-md-2 pt-2">
                <span class="badge" id="sample" v-bind:style="tagStyle" v-text="tagText"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 text-center">
                <input type="submit" name="register" value="{{ __('messages.register') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection