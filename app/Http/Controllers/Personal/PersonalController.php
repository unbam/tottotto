<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Personal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
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
     * 言語変更画面
     * @param $id User->id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editLang($id)
    {
        // ログイン中のユーザではない、もしくは権限が運用管理者以下の場合はNG
        if(Auth::user()->id != $id && Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $user = User::find($id);
        return view('personal.lang')->with('lang', $user->personal->lang);
    }

    /**
     * 言語変更処理
     * @param Request $request
     * @param         $id User->id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLang(Request $request, $id)
    {
        $user = User::find($id);

        if(isset($user->personal->id)) {
            $personal = Personal::find($user->personal->id);
        }
        else {
            $personal = new Personal;
            $personal->user_id = $user->id;
            $personal->view = 0;
            $personal->per_page = 10;
            $personal->theme = 0;
        }

        $personal->lang = $request->lang;
        $personal->save();

        // 言語設定
        \App::setLocale($personal->lang);

        return redirect()->route('personal.lang.edit', $id)->with([
            'lang' => $personal->lang,
            'flash_message' => __('messages.updated')
        ]);
    }

    /**
     * 表示変更画面
     * @param $id User->id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editView($id)
    {
        // ログイン中のユーザではない、もしくは権限が運用管理者以下の場合はNG
        if(Auth::user()->id != $id && Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $user = User::find($id);

        return view('personal.view')->with('personal', $user->personal);
    }

    /**
     * 表示変更処理
     * @param Request $request
     * @param         $id User->id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateView(Request $request, $id)
    {
        $user = User::find($id);

        if(isset($user->personal->id)) {
            $personal = Personal::find($user->personal->id);
        }
        else {
            $personal = new Personal;
            $personal->user_id = $user->id;
            $personal->lang = 'ja';
            $personal->theme = 0;
        }

        $personal->view = $request->view;
        $personal->per_page = $request->per_page;
        $personal->save();

        return redirect()->route('personal.view.edit', $id)->with([
            'lang' => $personal->lang,
            'flash_message' => __('messages.updated')
        ]);
    }

    public function editTheme($id)
    {
        // TODO: テーマ変更
        /*// ログイン中のユーザではない、もしくは権限が運用管理者以下の場合はNG
        if(Auth::user()->id != $id && Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $user = User::find($id);*/
    }

    public function updateTheme(Request $request, $id)
    {
        // TODO: テーマ変更
    }
}
