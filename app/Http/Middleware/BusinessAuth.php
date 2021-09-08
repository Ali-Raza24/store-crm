<?php

namespace App\Http\Middleware;

use App\Constants\IStatus;
use App\Models\Business;
use App\Models\Store;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BusinessAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()){
            return redirect()->intended('/login');
        }

        View::share('business', optional(\Auth::user())->business);
        $plan = optional(Auth::user()->business)->plan;
        View::share('selectedPlan', $plan);
        View::share('selectedPlanOptions', optional($plan)->planoption);

        return $next($request);
    }
}
