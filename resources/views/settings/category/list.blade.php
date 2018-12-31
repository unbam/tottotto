{{-- カテゴリ一覧画面 --}}
@extends('layouts.app')
@section('title', __('messages.list_value', ['value' => __('messages.category')]))
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.list_value', ['value' => __('messages.category')]) }}</h3>
    </div>
    <div class="py-3">
        <a href="{{ action('Settings\CategoryController@add') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i>{{ __('messages.new_register') }}
        </a>
    </div>
    <table class="table table-striped table-hover" id="confirm">
        <thead>
            <tr>
                <th>{{ __('messages.category_name') }}</th>
                <th>{{ __('messages.created_date') }}</th>
                <th>{{ __('messages.updated_date') }}</th>
                <th class="col-del text-center">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>
                    <a href="{{ action('Settings\CategoryController@edit', $category->id) }}">{{ $category->name }}</a>
                </td>
                <td>{{ $category->created_at->format('Y-m-d') }}</td>
                <td>{{ $category->updated_at->format('Y-m-d') }}</td>
                <td class="col-del text-center">
                    <form action="{{ action('Settings\CategoryController@delete', $category->id) }}" method="POST">
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
        {!! $categories->render() !!}
    </div>
@endsection