<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/manifest.js') }}" defer></script>
        <script src="{{ asset('js/vendor.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/modal.js') }}" defer></script>
        @yield('scripts')

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
              integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        {{-- TODO: テーマ --}}
        {{--<link href="{{ asset('css/dark.css') }}" rel="stylesheet">--}}
        @yield('css')
    </head>
    <body>
        <div id="app">
            @if(!Request::is('login'))
                @include('layouts.partials.header')
            @endif
            <div id="main" class="row">
                @if(Request::is('settings/*') or Request::is('personal/*'))
                    {{-- 設定画面 --}}
                    <div class="col-md-2 settings-menu">
                        @include('layouts.partials.sidebar')
                    </div>
                    <div class="col-md-10 settings-content">
                        @include('layouts.partials.alert')
                        @yield('content')
                    </div>
                @else
                    {{-- メイン画面 --}}
                    <div class="col-md-12 pt-4 px-5">
                        @include('layouts.partials.alert')
                        @yield('content')
                    </div>
                @endif
            </div>
        </div>
        <div id="confirm">
        </div>
    </body>
</html>
