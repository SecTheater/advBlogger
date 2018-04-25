<?php

namespace App\Http\Middleware;
use Sentinel;
use Closure;

class UserMiddleware
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
        if(Sentinel::check()){
            
            return $next($request);
        }
        return redirect()->route('login')->with('info','Perhaps you forgot to login');
    }
}
