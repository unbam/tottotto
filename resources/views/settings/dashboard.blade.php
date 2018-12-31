{{-- ダッシュボード画面 --}}
@extends('layouts.app')
@section('title', __('messages.dashboard'))
@section('scripts')
    <script src="{{ asset('js/chart.js') }}" defer></script>
@endsection
@section('css')
    <link href="{{ asset('css/chart.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="page-header">
        <h3>{{ __('messages.dashboard') }}</h3>
    </div>
    <div class="py-3">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('messages.count_articles_monthly') }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <canvas id="monthly-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('messages.count_articles_categories') }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <canvas id="category-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('messages.count_articles_tags') }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <canvas id="tag-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('messages.count_tags') }}</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <h4>{{ $tagCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('messages.count_categories') }}</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <h4>{{ $categoryCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h6>{{ __('messages.count_users') }}</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <h4>{{ $userCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        {{-- システム管理者のみ --}}
        @if(Auth::user()->role->level >= 100)
            <div class="card mt-3">
                <div class="card-header">
                    <h6>{{ __('messages.system_logs') }}</h6>
                </div>
                <div class="card-body p-3">
                    @if(count($logs) > 0)
                        <table class="table table-striped table-hover system-log-table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.row') }}</th>
                                    <th>{{ __('messages.error_date') }}</th>
                                    <th>{{ __('messages.message') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log['row'] }}</td>
                                    <td>{{ $log['date'] }}</td>
                                    <td>{{ $log['content'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- ページネーション --}}
                        {{--<div class="row justify-content-md-center">
                            {!! $logs->links() !!}
                        </div>--}}
                    @else
                        <p>{{ __('messages.nothing', ['value' => __('messages.error_message')]) }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection