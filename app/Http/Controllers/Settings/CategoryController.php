<?php

namespace App\Http\Controllers\Settings;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * コンストラクタ
     * CategoryController constructor.
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
        $categories = Category::select()->paginate(10);

        return view('settings.category.list')->with('categories', $categories);
    }

    /**
     * 追加画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('settings.category.add');
    }

    /**
     * 追加処理
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(CategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return redirect()->route('settings.category.list')->with('flash_message', __('messages.registered'));
    }

    /**
     * 変更画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('settings.category.edit')->with('category', $category);
    }

    /**
     * 更新処理
     * @param CategoryRequest $request
     * @param                 $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('settings.category.list')->with('flash_message', __('messages.updated'));
    }

    /**
     * 削除処理
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('settings.category.list')->with('flash_message', __('messages.deleted'));
    }
}
