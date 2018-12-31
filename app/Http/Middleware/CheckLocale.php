<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 言語設定ミドルウェア
 * @package App\Http\Middleware
 */
class CheckLocale
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
        if(isset(\Auth::user()->personal) && \Auth::user()->personal->lang == 'en') {
            \App::setLocale('en');
        }
        else {
            \App::setLocale('ja');
        }

        return $next($request);
    }
}
