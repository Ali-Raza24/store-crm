<?php

namespace App\Http\Middleware;

use App\Models\BusinessToken;
use Closure;
use Illuminate\Http\Request;

class StoreAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->bearerToken())) {
            return response()->json([
                'status' => false,
                'message' => 'Bearer token required',
            ]);
        } else {
            $token = \Crypt::decrypt($request->bearerToken());
            $businessToken = BusinessToken::whereToken($token)->latest()->first();
            if ($businessToken) {
                \Auth::login($businessToken->business->user);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid token'
                ]);
            }
        }
        return $next($request);
    }
}
