<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 権限チェックミドルウェア
 * @package App\Http\Middleware
 */
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 一般の場合はトップにリダイレクト
        if(\Auth::user()->role->level < 10) {
            return redirect()->route('post.index')->with('flash_message', __('messages.not_permission'));
        }

        return $next($request);
    }
}
