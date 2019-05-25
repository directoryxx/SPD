<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;


class AdminCheck extends Middleware
{
    protected $guards = [];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            if (Auth::user()->id == null){
                return redirect('login');
            } else {
                if (Auth::user()->roles != 1){
                    return redirect('login');
                }
            }
            //return redirect('/home');
        } else {
            return redirect('login');
        }

        return $next($request);
    }
}
