<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Contracts\Auth\Factory as Auth;

class CheckLevel
{
    // protected $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if(Auth::user()->level!=6){
        //     return response('Unauthorized.', 401);
        // }

        return $next($request);
    }
}