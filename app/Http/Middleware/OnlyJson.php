<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class OnlyJson
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
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader != 'application/json') {
            return response()->json(['status' => false, 'message' => 'Only accept json. Please check your headers'], 400);
        }
        return $next($request);
    }
}
