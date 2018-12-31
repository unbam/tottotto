{{-- カレンダー画面 --}}
@extends('layouts.app')
@section('title', __('messages.calendar'))
@section('scripts')
    <script src="{{ asset('js/calendar.js') }}" defer></script>
    <script src="{{ asset('js/select.js') }}" defer></script>
@endsection
@section('css')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select.css') }}" rel="stylesheet">
@endsection
@section('content')
    {{-- カレンダー --}}
    <div id='calendar'></div>

    {{-- 検索フォーム --}}
    <form method="get" action="" class="form-horizontal my-4" id="collapse-search" style="display: none">
        <div class="row">
            <div class="col-md-3">
                <label for="keyword" class="col-form-label-sm p-0">{{ __('messages.keyword') }}</label>
                <input type="text" name="keyword" class="form-control form-control-sm" id="keyword" value="{{ $keyword }}"
                       placeholder="{{ __('messages.keyword') }}">
            </div>
            <div class="col-md-2">
                <label for="tag" class="col-form-label-sm p-0">{{ __('messages.tag') }}</label>
                <select class="form-control form-control-sm selectpicker" id="tag" name="tags[]" multiple title="{{ __('messages.all') }}">
                    {{-- TODO: タグ --}}
                    {{--<option value="0" @if(collect($tagIds)->contains('0')) selected @endif>なし</option>--}}
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if(collect($tagIds)->contains($tag->id)) selected @endif>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label for="status" class="col-form-label-sm p-0">{{ __('messages.status') }}</label>
                <select class="form-control form-control-sm selectpicker" id="status" name="status">
                    <option value="0" @if($statusId == 0) selected @endif>{{ __('messages.all') }}</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" @if($statusId == $status->id) selected @endif>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label for="category" class="col-form-label-sm p-0">{{ __('messages.category') }}</label>
                <select class="form-control form-control-sm selectpicker" id="category" name="category">
                    <option value="0" @if($categoryId == 0) selected @endif>{{ __('messages.all') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($categoryId == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="auther" class="col-form-label-sm p-0">{{ __('messages.author') }}</label>
                <select class="form-control form-control-sm selectpicker" id="author" name="author">
                    <option value="0" @if($userId == 0) selected @endif>{{ __('messages.all') }}</option>
                    <option value="{{ Auth::user()->id }}" @if($userId == Auth::user()->id) selected @endif>{{ Auth::user()->name }}</option>
                </select>
            </div>
            <div class="col-md-1 align-self-end">
                <button type="submit" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-search"></i>{{ __('messages.search') }}
                </button>
            </div>
        </div>
        {{-- 検索トグルボタンの状態 --}}
        <input type="hidden" id="toggle" name="toggle" value="{{ $toggle }}">
    </form>
@endsection