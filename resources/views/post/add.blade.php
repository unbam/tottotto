{{-- 投稿追加画面 --}}
@extends('layouts.app')
@section('title', __('messages.add_value', ['value' => __('messages.post')]))
@section('scripts')
    <script src="{{ asset('js/select.js') }}" defer></script>
@endsection
@section('css')
    <link href="{{ asset('css/select.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.add_value', ['value' => __('messages.post')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ route(strpos($_SERVER['HTTP_REFERER'], '/post/calendar') ? 'post.calendar' : 'post.list') }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <form action="" method="post" class="form-horizontal">
        @csrf
        <input type="hidden" name="ref" value="{{ $_SERVER['HTTP_REFERER'] }}">
        <div class="card">
            <div class="card-header">
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="{{ __('messages.title') }}">
                @if($errors->has('title'))<span class="text-danger">{{ $errors->first('title') }}</span> @endif
            </div>
            <div class="card-body p-3">
                <textarea class="form-control" id="content" name="content"
                          style="height: 400px; width: 100%; background-color: inherit;"
                          placeholder="{{ __('messages.content') }}">{{ old('content') }}</textarea>
            </div>
            <div class="card-footer">
                <div class="row py-1">
                    <label for="status" class="col-md-2 text-md-right">{{ __('messages.status') }}</label>
                    <div class="col-md-3 mr-auto">
                        <select class="form-control form-control-sm selectpicker" id="status" name="status">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" @if(old('status') == $status->id) selected @endif>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="category" class="col-md-2 text-md-right">{{ __('messages.category') }}</label>
                    <div class="col-md-3 mr-auto">
                        <select class="form-control form-control-sm selectpicker" id="category" name="category" style="width: 250px;" >
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row py-1">
                    <label for="date" class="col-md-2 text-md-right">{{ __('messages.posted_date') }}</label>
                    <div class="col-md-3 mr-auto">
                        <input type="datetime-local" class="form-control" id="date" name="date" value="{{ old('date', $date) }}">
                        @if($errors->has('date'))<span class="text-danger">{{ $errors->first('date') }}</span> @endif
                    </div>
                    <label for="author" class="col-md-2 text-md-right">{{ __('messages.author') }}</label>
                    <div class="col-md-3 mr-auto">
                        <span id="author">{{ Auth::user()->name }}</span>
                    </div>
                </div>
                <div class="row py-1">
                    <label for="tag" class="col-md-2 col-form-label text-md-right">{{ __('messages.tag') }}</label>
                    <div class="col-md-3  mr-auto">
                        <select class="form-control selectpicker" id="tag" name="tags[]" multiple data-width="fit" title="">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" @if(collect(old('tags'))->contains($tag->id)) selected @endif>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-md-4 offset-md-4 text-center">
                <input type="submit" name="register" value="{{ __('messages.post') }}" class="btn btn-primary btn-wide" />
            </div>
        </div>
    </form>
@endsection