<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Status;
use App\Tag;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    /**
     * コンストラクタ
     * PostController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * カレンダー表示画面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calendar(Request $request)
    {
        // タグの取得
        $tags = Tag::select(['id', 'name', 'color', 'background_color'])->orderBy('id')->get();

        // 状態の取得
        $statuses = Status::select(['id', 'name'])->orderBy('id')->get();

        // カテゴリの取得
        $categories = Category::select(['id', 'name'])->orderBy('id')->get();

        // 検索キーワード取得
        $keyword = $request->input('keyword');

        // 検索対象タグ取得
        $tagIds = $request->input('tags');

        // 検索対象ステータス取得
        $statusId = $request->input('status');

        // 検索対象カテゴリ取得
        $categoryId = $request->input('category');

        // 検索対象ユーザー取得
        $userId = $request->input('author');

        // 検索フォーム表示
        $toggle = $request->input('toggle');

        return view('post.calendar')->with([
            'keyword' => $keyword,
            'tags' => $tags,
            'tagIds' => $tagIds,
            'statuses' => $statuses,
            'statusId' => $statusId,
            'categories' => $categories,
            'categoryId' => $categoryId,
            'userId' => $userId,
            'toggle' => $toggle
        ]);
    }

    /**
     * カレンダーの月別投稿取得
     * @param Request $request
     * @return string
     */
    public function getMonthPostsJson(Request $request)
    {
        // 入力チェックルール
        $validateRules = [
            'start'=>'date',
            'end'=>'date'
        ];

        // バリデーション実行
        $this->validate($request, $validateRules);

        // クエリ生成
        $query = Post::query();

        // 検索キーワード
        if(!empty($request->keyword)) {
            $query->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('content', 'like', '%' . $request->keyword . '%');
        }

        // 検索対象タグ
        if(!empty($request->tagIds)) {
            $tagIds = $request->tagIds;
            $query->whereHas('tags', function($q) use($tagIds) {
                $q->whereIn('tag_id', $tagIds);
            });
        }

        // 検索対象ステータス
        if(!empty($request->statusId) && $request->statusId != 0) {
            $query->where('status_id', '=', $request->statusId);
        }

        // 検索対象カテゴリ
        if(!empty($request->categoryId) && $request->categoryId != 0) {
            $query->where('category_id', '=', $request->categoryId);
        }

        // 検索対象ユーザー
        if(!empty($request->userId) && $request->userId != 0) {
            $query->where('user_id', '=', $request->userId);
        }

        // 検索期間
        $query->whereBetween('posted_at', [$request->start, $request->end]);

        // 投稿の取得
        $posts = $query->orderBy('posted_at')->get();

        // イベントリスト
        $events = array();
        foreach($posts as $post) {
            $events[] = [
                'post_id' => $post->id,
                'title' => $post->title,
                'start' => $post->posted_at->format('Y-m-d H:i'),
            ];
        }

        // JSONで返却
        return json_encode($events);
    }

    /**
     * 投稿一覧画面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        // タグの取得
        $tags = Tag::select(['id', 'name', 'color', 'background_color'])->orderBy('id')->get();

        // 状態の取得
        $statuses = Status::select(['id', 'name'])->orderBy('id')->get();

        // カテゴリの取得
        $categories = Category::select(['id', 'name'])->orderBy('id')->get();

        // クエリ生成
        $query = Post::query();

        // 検索キーワード取得
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {
            $query->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('content', 'like', '%' . $keyword . '%');
        }

        // 検索対象タグ取得
        $tagIds = $request->input('tags');
        if(!empty($tagIds)) {
            $query->whereHas('tags', function($q) use($tagIds) {
                $q->whereIn('tag_id', $tagIds);
            });
        }

        // 検索対象ステータス取得
        $statusId = $request->input('status');
        if(!empty($statusId) && $statusId != 0) {
            $query->where('status_id', '=', $statusId);
        }

        // 検索対象カテゴリ取得
        $categoryId = $request->input('category');
        if(!empty($categoryId) && $categoryId != 0) {
            $query->where('category_id', '=', $categoryId);
        }

        // 検索対象ユーザー取得
        $userId = $request->input('author');
        if(!empty($userId) && $userId != 0) {
            $query->where('user_id', '=', $userId);
        }

        // 表示件数
        $perPage = $request->input('per');
        if(empty($perPage)) {
            $perPage = isset(Auth::user()->personal) ? Auth::user()->personal->per_page : 10;
        }

        $posts = $query->sortable(['posted_at' => 'desc'])->paginate($perPage);
        return view('post.list')->with([
            'posts' => $posts,
            'keyword' => $keyword,
            'tags' => $tags,
            'tagIds' => $tagIds,
            'statuses' => $statuses,
            'statusId' => $statusId,
            'categories' => $categories,
            'categoryId' => $categoryId,
            'userId' => $userId,
            'perPage' => $perPage
        ]);
    }

    /**
     * 追加画面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        // 投稿日時
        $date = $request->date . 'T' . date('H:i');

        // タグの取得
        $tags = Tag::select(['id', 'name', 'color', 'background_color'])->orderBy('id')->get();

        // 状態の取得
        $statuses = Status::select(['id', 'name'])->orderBy('id')->get();

        // カテゴリの取得
        $categories = Category::select(['id', 'name'])->orderBy('id')->get();

        return view('post.add')->with([
            'date' => $date,
            'tags' => $tags,
            'statuses' => $statuses,
            'categories' => $categories
        ]);
    }

    /**
     * 追加処理
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(PostRequest $request)
    {
        $post = new Post;
        $post->title = $request->request->get('title');
        $post->content = $request->request->get('content');
        $post->posted_at = date_create($request->request->get('date'));
        $post->is_notifiable = 0;   // TODO: メール通知機能
        $post->status_id = $request->request->get('status');
        $post->category_id = $request->request->get('category');
        $post->user_id = \Auth::user()->id;
        $post->save();

        // 投稿とタグのリレーションテーブルへの保存
        $tags = Input::get('tags');
        if(isset($tags)) {
            foreach($tags as $tagId) {
                DB::table('posts_tags')->insert([
                    'post_id' => $post->id,
                    'tag_id' => $tagId
                ]);
            }
        }

        // カレンダーもしくは一覧画面に遷移
        $url = strpos($request->ref, '/post/calendar') ? 'post.calendar' : 'post.list';
        return redirect()->route($url)->with('flash_message', __('messages.posted'));
    }

    /**
     * 投稿表示画面
     * @param $id Post->id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $post = Post::find($id);

        $url = strpos($_SERVER['HTTP_REFERER'], '/post/calendar') ? 'post.calendar' : 'post.list';

        // セッションにURLを保存(editとdeleteの取得エラー時のリダイレクト先に使用)
        session(['url' => $url]);

        // 取得エラー
        if(!isset($post)) {
            return redirect()->route($url)
                ->with('flash_message', __('messages.not_found', ['value' => __('messages.article')]));
        }

        return view('post.view')->with('post', $post);
    }

    /**
     * 変更画面
     * @param $id Post->id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // 取得エラー
        if(!isset($post)) {
            // viewでセットしたセッションからリダイレクト先のURL取得
            return redirect()->route(session('url'))
                ->with('flash_message', __('messages.not_found', ['value' => __('messages.article')]));
        }

        // ログイン中のユーザではない、もしくは権限が一般の場合はNG
        if(Auth::user()->id != $post->user_id && Auth::user()->role->level < 10){
            return back()->with('flash_message', __('messages.not_permission'));
        }

        // タグの取得
        $tags = Tag::select(['id', 'name', 'color', 'background_color'])->get();

        // 状態の取得
        $statuses = Status::select(['id', 'name'])->get();

        // カテゴリの取得
        $categories = Category::select(['id', 'name'])->get();

        // 設定されているタグのIDリスト
        $myTags = array();
        foreach($post->tags as $tag) {
            $myTags[] = $tag->id;
        }

        return view('post.edit')->with([
            'post' => $post,
            'tags' => $tags,
            'myTags' => $myTags,
            'statuses' => $statuses,
            'categories' => $categories
        ]);
    }

    /**
     * 更新処理
     * @param PostRequest $request
     * @param             $id Post->id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        // 取得エラー
        if(!isset($post)) {
            // viewでセットしたセッションからリダイレクト先のURL取得
            return redirect()->route(session('url'))
                ->with('flash_message', __('messages.not_found', ['value' => __('messages.article')]));
        }

        $post->title = $request->request->get('title');
        $post->content = $request->request->get('content');
        $post->posted_at = date_create($request->request->get('date'));
        $post->is_notifiable = 0;   // TODO: メール通知機能
        $post->status_id = $request->request->get('status');
        $post->category_id = $request->request->get('category');
        $post->save();

        // 投稿とタグのリレーション削除
        DB::table('posts_tags')->where('post_id', '=', $id)->delete();

        // 投稿とタグのリレーションテーブルへの保存
        $tags = Input::get('tags');
        if(isset($tags)) {
            foreach($tags as $tagId) {
                DB::table('posts_tags')->insert([
                    'post_id' => $post->id,
                    'tag_id' => $tagId
                ]);
            }
        }

        return redirect()->route('post.view', $id)->with('flash_message', __('messages.updated'));
    }

    /**
     * 削除処理
     * @param $id Post->id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $post = Post::find($id);

        // 取得エラー
        if(!isset($post)) {
            // リストから削除の場合はリスト画面にリダイレクトそれ以外は、viewでセットしたセッションからリダイレクト先のURL取得
            $url = strpos($_SERVER['HTTP_REFERER'], '/post/list') ? 'post.list' : session('url');
            return redirect()->route($url)
                ->with('flash_message', __('messages.not_found', ['value' => __('messages.article')]));
        }

        // ログイン中のユーザではない、もしくは権限が一般の場合はNG
        if(Auth::user()->id != $post->user_id && Auth::user()->role->level < 10){
            return back()->with('flash_message', __('messages.not_permission'));
        }

        // 削除
        $post->delete();
        DB::table('posts_tags')->where('post_id', '=', $id)->delete();

        // カレンダーもしくは一覧画面に遷移
        $url = strpos($request->ref, '/post/calendar') ? 'post.calendar' : 'post.list';
        return redirect()->route($url)->with('flash_message', __('messages.deleted'));
    }
}
