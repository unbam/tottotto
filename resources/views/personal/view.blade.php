{{-- 表示変更画面 --}}
@extends('layouts.app')
@section('title', __('messages.edit_value', ['value' => __('messages.view')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.edit_value', ['value' => __('messages.view')]) }}</h3>
    </div>
    <form action="" method="post" class="py-3">
        @csrf
        <h5>{{ __('messages.default_view') }}</h5>
        <div class="form-group form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="view" id="view-list" value="0" @if($personal->view == 0) checked @endif>
                {{ __('messages.list') }}
            </label>
        </div>
        <div class="form-group form-check form-check-inline ml-5">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="view" id="view-calendar" value="1" @if($personal->view == 1) checked @endif>
                {{ __('messages.calendar') }}
            </label>
        </div>
        <h5 class="mt-4">{{ __('messages.results_per_page') }}</h5>
        <div class="form-group form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="per_page" id="page_10" value="10" @if($personal->per_page == 10) checked @endif>
                10
            </label>
        </div>
        <div class="form-group form-check form-check-inline ml-5">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="per_page" id="page_20" value="20" @if($personal->per_page == 20) checked @endif>
                20
            </label>
        </div>
        <div class="form-group form-check form-check-inline ml-5">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="per_page" id="page_50" value="50" @if($personal->per_page == 50) checked @endif>
                50
            </label>
        </div>
        <div class="form-group form-check form-check-inline ml-5">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="per_page" id="page_100" value="100" @if($personal->per_page == 100) checked @endif>
                100
            </label>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <input type="submit" name="update" value="{{ __('messages.update') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection