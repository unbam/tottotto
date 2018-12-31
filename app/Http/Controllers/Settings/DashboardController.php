<?php

namespace App\Http\Controllers\Settings;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Log\Logger;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        // 登録数
        $tagCount = Tag::all()->count();
        $categoryCount = Category::all()->count();
        $userCount = User::all()->count();

        // エラーログリスト
        $paginateLogs = [];

        // システム管理者のみエラーログ表示
        if(Auth::user()->role->level >= 100){

            $filePath = storage_path() . '/logs/laravel.log';
            $logs = [];
            if(file_exists($filePath)) {
                $logFile = file($filePath);
                foreach ($logFile as $lineNum => $line) {

                    // エラーメッセージの先頭のみ取得(スタックトレースは除外)
                    if(strpos($line, 'local.ERROR:') > 0) {

                        // 文字コードをSJISからUTF-8に変換
                        mb_convert_variables('UTF-8', 'sjis-win', $line);

                        $date = substr($line, 1, 19);
                        $content = substr($line, 35);

                        if(mb_strlen($content) > 500) {
                            $content = substr($content, 0, 499) . '...';
                        }

                        $logs[] = array('row'=> ($lineNum + 1), 'date' => $date, 'content'=> $content);
                    }
                }
            }

            $sortedLogs = collect($logs)->sortByDesc('date')->toArray();

            // 指定件数単位で配列を分割
            $chunkLogs = array_chunk($sortedLogs, 3);

            // TODO: ページネーションを非同期にする
            // 1. ページネーションする場合
            /*$currentPageNo = $request->input('page', 1);
            $paginateLogs = new LengthAwarePaginator(count($chunkLogs) > 0 ? $chunkLogs[$currentPageNo - 1] : $chunkLogs,
                count($sortedLogs), 3, $currentPageNo, array('path' =>  $request->url()));*/

            // 2. 最新ログのみを表示
            $paginateLogs = count($chunkLogs) > 0 ? $chunkLogs[0] : $chunkLogs;
        }

        return view('settings.dashboard')->with([
            'tagCount' => $tagCount,
            'categoryCount' => $categoryCount,
            'userCount' => $userCount,
            'logs' => $paginateLogs
        ]);
    }

    /**
     * 月間記事数の取得
     * @param Request $request
     * @return string
     */
    public function getMonthTotalJson(Request $request)
    {
        $monthTotal = Post::select(DB::raw('DATE_FORMAT(posted_at, \'%Y%m\') as month, count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(posted_at, \'%Y\')'), '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')->get();

        // JSON
        $json = array();
        foreach($monthTotal as $total) {
            $json[] = [
                'month' => $total->month,
                'count' => $total->count
            ];
        }

        // JSONで返却
        return json_encode($json);
    }

    /**
     * カテゴリごとの年間記事数の取得
     * @param Request $request
     * @return string
     */
    public function getCategoryTotalJson(Request $request)
    {
        $categoryTotal = DB::table('posts')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select('categories.id as id', 'categories.name as name', DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(posted_at, \'%Y\')'), '=', date('Y'))
            ->groupBy('id', 'name')
            ->orderBy('id')->get();

        // JSON
        $json = array();
        foreach($categoryTotal as $total) {
            $json[] = [
                'name' => $total->name,
                'count' => $total->count
            ];
        }

        // JSONで返却
        return json_encode($json);
    }

    /**
     * タグごとの年間記事数の取得
     * @param Request $request
     * @return string
     */
    public function getTagTotalJson(Request $request)
    {
        $tagTotal = DB::table('posts')
            ->join('posts_tags', 'posts_tags.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'tags.id', '=', 'posts_tags.tag_id')
            ->select('tags.id as id', 'tags.name as name', 'tags.background_color as background_color', DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(posted_at, \'%Y\')'), '=', date('Y'))
            ->groupBy('id', 'name', 'background_color')
            ->orderBy('id')->get();

        // JSON
        $json = array();
        foreach($tagTotal as $total) {
            $json[] = [
                'name' => $total->name,
                'background_color' => $total->background_color,
                'count' => $total->count
            ];
        }

        // JSONで返却
        return json_encode($json);
    }
}
