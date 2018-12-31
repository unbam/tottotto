<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Personal;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * コンストラクタ
     * UserController constructor.
     */
    public function __construct()
    {
       $this->middleware('auth');

       // このコントローラは個人設定も流用するためここではadminのミドルウェアを設定せず、
       // listメソッド内で権限チェックを行う
    }

    /**
     * 一覧画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        // 運用管理者以下はリダイレクト
        if(Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $users = User::select()->orderBy('created_at', 'desc')->paginate(10);

        return view('settings.user.list')->with('users', $users);
    }

    /**
     * 追加画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        // 権限の取得
        $roles = Role::select(['id', 'name'])->orderBy('id', 'desc')->get();

        return view('settings.user.add')->with('roles', $roles);
    }

    /**
     * 追加処理
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(UserRequest $request)
    {
        $user = new User;
        $user->login_id = $request->login_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        // 個人設定の登録
        $this->insertPersonal($user->id);

        return redirect()->route('settings.user.list')->with('flash_message', __('messages.registered'));
    }

    /**
     * 変更画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // ログイン中のユーザではない、もしくは権限が運用管理者以下の場合はNG
        if(Auth::user()->id != $id && Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $user = User::find($id);
        $roles = Role::select(['id', 'name'])->orderBy('id', 'desc')->get();

        return view('settings.user.edit')->with(['user' => $user, 'roles' => $roles]);
    }

    /**
     * 更新処理
     * @param UserRequest $request
     * @param             $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->login_id = $request->login_id;
        $user->name = $request->name;
        $user->email = $request->email;

        // システム管理者のみ権限を修正可能
        if(isset($request->role) && Auth::user()->role->level >= 100) {
            $user->role_id = $request->role;
        }

        $user->save();

        // 個人設定での変更
        if(strpos($_SERVER['HTTP_REFERER'], '/personal')) {
            return redirect()->route('personal.user.edit', $id)->with('flash_message', __('messages.updated'));
        }

        return redirect()->route('settings.user.list')->with('flash_message', __('messages.updated'));
    }

    /**
     * パスワード変更画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPassword($id)
    {
        // ログイン中のユーザではない、もしくは権限が運用管理者以下の場合はNG
        if(Auth::user()->id != $id && Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $user = User::find($id);

        return view('settings.user.password')->with('user', $user);
    }

    /**
     * パスワード変更処理
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required|min:1|max:30|current_password:' . $id,
            'new_password' => 'required|min:1|max:30|confirmed'
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();

        // 個人設定での変更
        if(strpos($_SERVER['HTTP_REFERER'], '/personal')) {
            return redirect()->route('personal.user.edit', $id)->with('flash_message', __('messages.updated'));
        }

        return redirect()->route('settings.user.edit', $id)->with('flash_message', __('messages.updated'));
    }

    /**
     * 削除処理
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        // ログイン中のユーザではない、もしくは権限が運用管理者以下の場合はNG
        if(Auth::user()->id != $id && Auth::user()->role->level <= 10) {
            return back()->with('flash_message', __('messages.not_permission'));
        }

        $user = User::find($id);
        $user->delete();

        // 個人設定での削除はログイン画面に遷移
        if(strpos($_SERVER['HTTP_REFERER'], '/personal')) {
            return redirect('/login');
        }

        return redirect()->route('settings.user.list')->with('flash_message', __('messages.deleted'));
    }

    /**
     * CSVインポート画面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import() {
        return view('settings.user.import');
    }

    /**
     * CSVインポートチェック
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkImport(Request $request) {

        // CSVファイルのバリデーション
        $this->validate($request, [
            'user_csv' => 'required|mimetypes:text/plain|mimes:csv,txt'
        ]);

        // CSVファイルをサーバーに保存
        $tempCsvFile = $request->file('user_csv')->store('csv');

        // CSV読み込み
        $file = new \SplFileObject(storage_path('app/') . $tempCsvFile);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        $users = array();   // 登録リスト
        $lineNo = 1;        // 行番号
        $errorCount = 0;    // エラー数

        // 権限取得
        $roles = Role::select(['name', 'level'])->get();

        foreach($file as $line) {

            if(isset($request->code) && $request->code === 'sjis') {
                // 文字コードをUTF-8へ変換
                mb_convert_variables('UTF-8', 'sjis-win', $line);
            }

            // ヘッダをスキップ
            if($lineNo === 1) {
                $lineNo++;
                continue;
            }

            $arr = array();
            $arr['is_error'] = 0;
            $arr['row'] = $lineNo;
            $arr['login_id'] = isset($line[0]) ? $line[0] : '';
            $arr['name'] = isset($line[1]) ? $line[1] : '';
            $arr['email'] = isset($line[2]) ? $line[2] : '';
            $arr['role_level'] = isset($line[3]) ? $line[3] : '';
            $arr['role_name'] = isset($line[3]) ? $roles->where('level', $line[3])->first()->name: '';
            $arr['error_message'] = '';

            // カラム数が不正
            if(count($line) !== 4) {
                $arr['is_error'] = 1;
                $arr['error_message'] = __('messages.error_column');
                $errorCount++;
            }
            else {
                // バリデーションチェック
                $validator = \Validator::make($arr, [
                    'login_id' => 'required|max:30|unique:users',
                    'name' => 'required|max:50',
                    'email' => 'required|email|max:255|unique:users',
                    'role_level' => 'required|numeric|min:1|max:100'    // TODO: 1,10,100のいずれか
                ]);

                // バリデーションエラーの場合
                if($validator->fails() === true) {
                    $arr['is_error'] = 1;
                    $arr['error_message'] = $validator->errors()->first();
                    $errorCount++;
                }
            }

            $users[$lineNo] = $arr;
            $lineNo++;
        }

        // 全てエラーの場合は登録ボタンを表示しない
        $isAllError = count($users) === $errorCount ? 1 : 0;

        if(!$isAllError) {
            // CSVインポート用にセッションに正常データのユーザを保存
            $request->session()->put('import_users', array_where($users, function($value) {
                return $value['is_error'] === 0;
            }));
        }

        return redirect()->route('settings.user.import')->with([
            'users' => $users,
            'is_all_error' => $isAllError
        ]);
    }

    /**
     * CSVインポート処理
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertImport(Request $request) {

        if(!$request->session()->has('import_users')) {
            return back()->with('error_message', __('messages.error_all_users'));
        }

        // 権限取得
        $roles = Role::select(['id', 'level'])->get();

        // セッションからインポートするユーザを取得
        $importUsers = $request->session()->get('import_users');

        // セッション削除
        $request->session()->forget('importUsers');

        // 保存
        DB::beginTransaction();

        try {
            foreach($importUsers as $importUser) {

                $user = new User;
                $user->login_id = $importUser['login_id'];
                $user->name = $importUser['name'];
                $user->email = $importUser['email'];
                $user->role_id = $roles->where('level', $importUser['role_level'])->first()->id;
                $user->password = Hash::make('test');   // TODO: メール通知して設定させる
                $user->save();

                // 個人設定の登録
                $this->insertPersonal($user->id);
            }

            DB::commit();
            return redirect()->route('settings.user.list')->with('flash_message', __('messages.registered'));
        }
        catch(\PDOException $pe){
            DB::rollBack();
            Log::error($pe->getMessage());
            return back()->with('error_message', __('messages.error_user'));
        }
        catch(\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->with('error_message', __('messages.error_user'));
        }
    }

    /**
     * 個人設定の登録
     * @param $userId
     */
    private function insertPersonal($userId) {
        $personal = new Personal;
        $personal->user_id = $userId;
        $personal->lang = 'ja';
        $personal->view = 0;
        $personal->per_page = 10;
        $personal->theme = 0;
        $personal->save();
    }
}
