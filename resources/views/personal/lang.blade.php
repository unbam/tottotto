{{-- 言語変更画面 --}}
@extends('layouts.app')
@section('title', __('messages.edit_value', ['value' => __('messages.language')]))
@section('scripts')
    <script src="{{ asset('js/lang.js') }}" defer></script>
@endsection
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.edit_value', ['value' => __('messages.language')]) }}</h3>
    </div>
    <div class="py-3"></div>
    <form action="" method="post" id="lang-page">
        @csrf
        <input type="hidden" name="v-lang" ref="lang" data-value="{{ $lang }}">
        <div class="form-group form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="lang" id="inlineRadio1" value="ja" @if($lang == 'ja') checked @endif v-model="lang">
                {{ __('messages.japanese') }}
            </label>
        </div>
        <div class="form-group form-check form-check-inline ml-5">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="lang" id="inlineRadio2" value="en" @if($lang == 'en') checked @endif v-model="lang">
                {{ __('messages.english') }}
            </label>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <input type="submit" name="update" value="{{ __('messages.update') }}" class="btn btn-primary btn-wide" v-on:click="changeLanguage"/>
            </div>
        </div>
    </form>
@endsection