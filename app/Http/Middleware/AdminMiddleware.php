<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class AdminMiddleware
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
       if(Sentinel::check() && Sentinel::hasAnyAccess(['admin.*','moderator.*'])){
            return $next($request);
       }
       return redirect()->back()->with('error','Insufficient Permissions');
    }
}
