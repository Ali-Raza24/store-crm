<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSubscribed
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

        if ($request->user() && $request->user()->business_id > 0) {
            if (!$request->user()->business->subscription('Plans')) {
                if ($request->user()->business->plan->monthly_price > 0 || $request->user()->business->plan->yearly_price > 0){
                    return redirect()->intended(route('upgrade-subscription'));
                }
            }
        }

        return $next($request);
    }
}
