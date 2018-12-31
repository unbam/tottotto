{{-- コメントコンポーネント --}}
<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-11">
                <h6>{{ __('messages.comment') }}</h6>
            </div>
            <div class="col-md-1">

            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- コメント一覧 --}}
        <div class="comments" id="comments">
            @if($post->comments->count() > 0)
                @foreach($post->comments as $comment)
                    <div class="row">
                        <div class="col-md-10 mr-auto">
                            <span class="small mr-1">{{ $comment->updated_at->format('Y-m-d H:i') }}</span>
                            <span class="small">[ {{ $comment->user->name }} ]</span>
                        </div>
                        <div class="col-md-2 ml-auto text-md-right">
                            @if(Auth::user()->id == $comment->user_id)
                                <a href="{{ action('CommentController@edit', $comment->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-edit"></i>{{ __('messages.edit') }}
                                </a>
                            @endif
                            @if(Auth::user()->id == $comment->user_id or Auth::user()->role->level >= 10)
                                <form class="d-inline ml-2" action="{{ action('CommentController@delete', $comment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-dell" v-on:click="confirm">
                                        <i class="fas fa-trash-alt"></i>{{ __('messages.delete') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if(Session::has('comment_id') and session('comment_id') == $comment->id)
                        {{-- コメント変更 --}}
                        <form id="edit-comment-form_{{ $comment->id }}" action="{{ route('comment.update', $comment->id) }}" method="post" class="form-horizontal mt-2">
                            @csrf
                            <textarea class="form-control" name="comment" rows="{{ substr_count($comment->comment, "\n") + 2 }}"
                                      style="width: 100%; background-color: inherit;">{{ $comment->comment }}</textarea>
                            <div class="row pt-2 justify-content-md-center">
                                <a class="btn btn-sm btn-outline-success" href="{{ route('comment.update', $comment->id) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('edit-comment-form_{{ $comment->id }}').submit();">
                                    <i class="fas fa-pen"></i>{{ __('messages.update') }}
                                </a>
                                <a class="btn btn-sm btn-outline-secondary ml-2" href="{{ action('PostController@view', $post->id) }}">
                                    {{ __('messages.cancel') }}
                                </a>
                            </div>
                        </form>
                    @else
                        {{-- コメント表示 --}}
                        <textarea class="form-control" name="comment" rows="{{ substr_count($comment->comment, "\n") + 2 }}"
                                  style="width: 100%; border: none; background-color: inherit; resize: none;" disabled readonly>{{ $comment->comment }}</textarea>
                    @endif
                    <hr>
                @endforeach
            @else
                <p>{{ __('messages.no_comments') }}</p>
                <hr>
            @endif
        </div>
        {{-- 新規コメント欄 --}}
        <div class="new-comment">
            <form id="add-comment-form" action="{{ route('comment.insert', $post->id) }}" method="post" class="form-horizontal">
                @csrf
                <div class="row pt-2">
                    <textarea class="form-control mx-3" id="comment" name="comment"
                              style="width: 100%; background-color: inherit;" placeholder="{{ __('messages.comment') }}"></textarea>
                </div>
                <div class="row pt-2 justify-content-md-center">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('comment.insert', $post->id) }}"
                       onclick="event.preventDefault();
                               document.getElementById('add-comment-form').submit();">
                        <i class="fas fa-plus"></i>{{ __('messages.add') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
