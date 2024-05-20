<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

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
        
        if (auth()->check() && auth()->user()) {
            return $next($request);
        }
        return redirect()->route('login')->with('errors', 'You are not authorized to access this page or using invalid crendetials.');
    }
}
