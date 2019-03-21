<?php

namespace App\Http\Middleware;

use Closure;

class LogMiddleware
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
       // dd(session('user_id'));
         if(empty(session('user_id'))){
             //exit("请登录后操作");
             return redirect('login');
         }
        return $next($request);
    }
}
