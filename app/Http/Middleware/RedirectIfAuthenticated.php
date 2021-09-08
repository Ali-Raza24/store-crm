<?php

namespace App\Http\Middleware;

use App\Models\Store;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        $redirectTo = RouteServiceProvider::HOME;
        if (Auth::check() && empty($request->user()->business_id)){
            $redirectTo = url('/admin');
        }
        if(Auth::check() && $request->user()->business_id > 0 ){
            $redirectTo = route('store-select');
        }
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}
