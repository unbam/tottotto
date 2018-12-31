<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * コンストラクタ
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 追加処理
     * @param CommentRequest $request
     * @param                $id Post->id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(CommentRequest $request, $id)
    {
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->post_id = $id;
        $comment->user_id = \Auth::user()->id;
        $comment->save();

        return redirect()->route('post.view', $id)->with('flash_message', __('messages.registered'));
    }

    public function edit($id)
    {
        $comment = Comment::find($id);

        if(!isset($comment)) {
            return redirect()->route('post.view', $id)->with('flash_message', __('messages.not_found', ['value' => __('messages.comment')]));
        }

        // ログイン中のユーザではない、もしくは権限が一般の場合はNG
        if(Auth::user()->id != $comment->user_id && Auth::user()->role->level < 10) {
            return back()->with('flash_message', '権限がありません。');
        }

        return redirect()->route('post.view', $comment->post_id)->with('comment_id', $comment->id);
    }

    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::find($id);

        if(!isset($comment)) {
            return redirect()->route('post.view', $id)->with('flash_message', __('messages.not_found', ['value' => __('messages.comment')]));
        }

        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('post.view', $comment->post_id)->with('flash_message', __('messages.updated'));
    }

    /**
     * 削除処理
     * @param $id Comment->id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $comment = Comment::find($id);

        if(!isset($comment)) {
            return redirect()->route('post.view', $id)->with('flash_message', __('messages.not_found', ['value' => __('messages.comment')]));
        }

        // ログイン中のユーザではない、もしくは権限が一般の場合はNG
        if(Auth::user()->id != $comment->user_id && Auth::user()->role->level < 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $comment->delete();
        $postId = $comment->post_id;

        return redirect()->route('post.view', $postId)->with('flash_message', __('messages.deleted'));
    }
}
