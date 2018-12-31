<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * フロントエンド側の言語設定の取得
     * @param Request $request
     * @return string
     */
    public function getLang(Request $request)
    {
        if(isset(\Auth::user()->personal) && \Auth::user()->personal->lang == 'en') {
            $lang = 'en';
        }
        else {
            $lang = 'ja';
        }

        return $lang;
    }
}
