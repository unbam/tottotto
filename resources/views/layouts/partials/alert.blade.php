{{-- フラッシュメッセージ --}}
@if(Session::has('flash_message'))
    <div class="alert alert-success fade show" id="flash_message" role="alert">
        {{ session('flash_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
            <span aria-hidden="true" class="fas fa-times"></span>
        </button>
    </div>
@endif

{{-- エラーメッセージ --}}
@if(Session::has('error_message'))
    <div class="alert alert-danger fade show" id="error_message" role="alert">
        {{ session('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
            <span aria-hidden="true" class="fas fa-times"></span>
        </button>
    </div>
@endif