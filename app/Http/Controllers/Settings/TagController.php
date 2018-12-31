<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * コンストラクタ
     * TagController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * 一覧画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $tags = Tag::select()->paginate(10);

        return view('settings.tag.list')->with('tags', $tags);
    }

    /**
     * 追加画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('settings.tag.add');
    }

    /**
     * 追加処理
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(TagRequest $request)
    {
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->color = $request->color;
        $tag->background_color = $request->background_color;
        $tag->save();

        return redirect()->route('settings.tag.list')->with('flash_message', __('messages.registered'));
    }

    /**
     * 変更画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        return view('settings.tag.edit')->with('tag', $tag);
    }

    /**
     * 更新処理
     * @param TagRequest $request
     * @param            $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagRequest $request, $id)
    {
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->color = $request->color;
        $tag->background_color = $request->background_color;
        $tag->save();

        return redirect()->route('settings.tag.list')->with('flash_message', __('messages.updated'));
    }

    /**
     * 削除処理
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $tag = Tag::find($id);
        $tag->delete();

        return redirect()->route('settings.tag.list')->with('flash_message', __('messages.deleted'));
    }
}
