<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthenticate
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
        $decode = base64_decode($request->app_token);
        if (!\Hash::check('SECURE_APP', $decode)){
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }
        return $next($request);
    }
}
