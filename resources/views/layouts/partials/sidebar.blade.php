<nav id="sidebar">
    <div class="container">
        <div class="sidebar-header">
            <h5>{{ __('messages.menu') }}</h5>
        </div>
        <ul class="nav nav-pills flex-column" id="side-nav">
            @if(Request::is('settings/*'))
                {{-- 設定メニュー --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.dashboard') }}">{{ __('messages.dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.tag.list') }}">{{ __('messages.tag') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.category.list') }}">{{ __('messages.category') }}</a>
                </li>
                {{-- システム管理者のみ --}}
                @if(Auth::user()->role->level >= 100)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('settings.user.list') }}">{{ __('messages.user') }}</a>
                    </li>
                @endif
            @else
                {{-- 個人設定メニュー --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('personal.user.edit', Auth::user()->id) }}">{{ __('messages.user') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('personal.lang.edit', Auth::user()->id) }}">{{ __('messages.language') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('personal.view.edit', Auth::user()->id) }}">{{ __('messages.view') }}</a>
                </li>
            @endif
        </ul>
    </div>
</nav>