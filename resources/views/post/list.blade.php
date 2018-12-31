{{-- 投稿一覧画面 --}}
@extends('layouts.app')
@section('title', __('messages.list_value', ['value' => __('messages.post')]))
@section('scripts')
    <script src="{{ asset('js/select.js') }}" defer></script>
@endsection
@section('css')
    <link href="{{ asset('css/select.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.list_value', ['value' => __('messages.post')]) }}</h3>
    </div>
    <div class="py-3">
        <div class="row">
            <div class="col-sm-3 mr-auto">
                <a href="{{ action('PostController@add', ['date' => date('Y-m-d')]) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-pen-nib"></i>{{ __('messages.new_post') }}
                </a>
            </div>
            <div class="col-sm-3 text-md-right">
                <a href="{{ action('PostController@calendar') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-calendar-alt"></i>{{ __('messages.calendar') }}
                </a>
            </div>
        </div>
        <form method="get" action="" class="form-horizontal mt-3" id="collapse-search">
            <div class="row">
                <div class="col-md-3">
                    <label for="keyword" class="col-form-label-sm p-0">{{ __('messages.keyword') }}</label>
                    <input type="text" name="keyword" class="form-control form-control-sm" value="{{ $keyword }}"
                           placeholder="{{ __('messages.keyword') }}">
                </div>
                <div class="col-md-2">
                    <label for="tag" class="col-form-label-sm p-0">{{ __('messages.tag') }}</label>
                    <select class="form-control form-control-sm selectpicker" id="tag" name="tags[]" multiple title="{{ __('messages.all') }}">
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
                <div class="col-md-1 align-self-end ml-auto">
                    <label for="per" class="col-form-label-sm p-0">{{ __('messages.per_page') }}</label>
                    <select class="form-control form-control-sm selectpicker" id="per" name="per" onchange="submit();">
                        <option value="10" @if($perPage == 10) selected @endif>10</option>
                        <option value="20" @if($perPage == 20) selected @endif>20</option>
                        <option value="50" @if($perPage == 50) selected @endif>50</option>
                        <option value="100" @if($perPage == 100) selected @endif>100</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped table-hover" id="confirm" style="word-break: break-all">
        <thead>
            <tr>
                <th>@sortablelink('title', __('messages.title'))</th>
                <th>{{ __('messages.tag') }}</th>
                <th>@sortablelink('status_id', __('messages.status'))</th>
                <th>@sortablelink('category_id', __('messages.category'))</th>
                <th>{{ __('messages.author') }}</th>
                <th>@sortablelink('posted_at', __('messages.posted_date'))</th>
                <th class="col-del text-center">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td style="max-width: 400px;">
                    <a href="{{ action('PostController@view', $post->id) }}">{{ $post->title }}</a>
                </td>
                <td>
                    @foreach($post->tags as $tag)
                        <span class="badge badge-tag"
                              style="color: {{ $tag->color }}; background-color: {{ $tag->background_color }};">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>{{ $post->status->name }}</td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->posted_at->format('Y-m-d H:i') }}</td>
                <td class="col-del text-center">
                    {{-- 権限チェック(自分自身もしくは運用管理者以上) --}}
                    @if(Auth::user()->id == $post->user_id or Auth::user()->role->level >= 10)
                        <form action="{{ action('PostController@delete', $post->id) }}" method="POST">
                            @csrf
                            <input type="submit" value="×" class="btn btn-sm btn-outline-danger rounded-circle" v-on:click="confirm">
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- ページネーション --}}
    <div class="row my-4">
        <div class="col-md-3">
            <span>{{ __('pagination.view', ['total' => $posts->total(), 'first' => $posts->firstItem(), 'last' => $posts->lastItem()]) }}</span>
        </div>
        <div class="mx-auto">
            {!! $posts->appends(\Illuminate\Support\Facades\Input::all())->render() !!}
        </div>
        <div class="col-md-3">
        </div>
    </div>
@endsection