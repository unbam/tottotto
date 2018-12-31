{{-- 投稿詳細画面 --}}
@extends('layouts.app')
@section('title', $post->title)
@section('content')
    <div class="py-3">
        <a href="{{ route(strpos($_SERVER['HTTP_REFERER'], '/post/calendar') ? 'post.calendar' : 'post.list') }}">
            <i class="fas fa-long-arrow-alt-left"></i>{{ __('messages.back') }}
        </a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>{{ $post->title }}</h3>
            <div class="row">
                <div class="col-md-10">
                    @foreach($post->tags as $tag)
                        <span class="badge badge-tag" style="color: {{ $tag->color }}; background-color: {{ $tag->background_color }};">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="col-md-2 text-md-right">
                    {{-- 権限チェック(自分自身のみ) --}}
                    @if(Auth::user()->id == $post->user_id)
                        <a href="{{ action('PostController@edit', $post->id) }}" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-edit"></i>{{ __('messages.edit') }}
                        </a>
                    @endif
                    {{-- 権限チェック(自分自身もしくは運用管理者以上) --}}
                    @if(Auth::user()->id == $post->user_id or Auth::user()->role->level >= 10)
                        <form class="d-inline ml-2" id="confirm" action="{{ action('PostController@delete', $post->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="ref" value="{{ $_SERVER['HTTP_REFERER'] }}">
                            <button type="submit" class="btn btn-sm btn-outline-danger" v-on:click="confirm">
                                <i class="fas fa-trash-alt"></i>{{ __('messages.delete') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            {{-- TODO: URL対応 --}}
            <textarea class="form-control" id="content" name="content" rows="{{ substr_count($post->content, "\n") + 2 }}"
                      style="width: 100%; border: none; background-color: inherit; resize: none;" disabled readonly>{{ $post->content }}</textarea>
        </div>
        <div class="card-footer">
            <div class="row">
                <label class="col-md-2 text-md-right">{{ __('messages.status') }}</label>
                <div class="col-md-3 mr-auto">{{ $post->status->name }}</div>
                <label class="col-md-2 text-md-right">{{ __('messages.category') }}</label>
                <div class="col-md-3 mr-auto">{{ $post->category->name }}</div>
            </div>
            <div class="row">
                <label class="col-md-2 text-md-right">{{ __('messages.posted_date') }}</label>
                <div class="col-md-3 mr-auto">{{ $post->posted_at->format('Y-m-d H:i') }}</div>
                <label class="col-md-2 text-md-right">{{ __('messages.author') }}</label>
                <div class="col-md-3 mr-auto">{{ $post->user->name }}</div>
            </div>
        </div>
    </div>
    {{-- コメント欄 --}}
    @include('post.comment')
@endsection