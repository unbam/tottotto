{{-- タグ一覧画面 --}}
@extends('layouts.app')
@section('title', __('messages.list_value', ['value' => __('messages.tag')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.list_value', ['value' => __('messages.tag')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\TagController@add') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i>{{ __('messages.new_register') }}
        </a>
    </div>
    <table class="table table-striped table-hover" id="confirm">
        <thead>
            <tr>
                <th>{{ __('messages.tag_name') }}</th>
                <th>{{ __('messages.tag_color') }}</th>
                <th>{{ __('messages.created_date') }}</th>
                <th>{{ __('messages.updated_date') }}</th>
                <th class="col-del text-center">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>
                    <a href="{{ action('Settings\TagController@edit', $tag->id) }}">{{ $tag->name }}</a>
                </td>
                <td>
                    <span class="badge badge-tag" style="color: {{ $tag->color }}; background-color: {{ $tag->background_color }};">{{ $tag->name }}</span>
                </td>
                <td>{{ $tag->created_at->format('Y-m-d') }}</td>
                <td>{{ $tag->updated_at->format('Y-m-d') }}</td>
                <td class="col-del text-center">
                    <form action="{{ action('Settings\TagController@delete', $tag->id) }}" method="POST">
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
        {!! $tags->render() !!}
    </div>
@endsection