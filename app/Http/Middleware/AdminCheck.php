<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->id == null){
                return redirect('login');
            } else {
                if (Auth::user()->roles != 1){
                    return redirect('login');
                }
            }
            //return redirect('/home');
        }

        return $next($request);
    }
}
