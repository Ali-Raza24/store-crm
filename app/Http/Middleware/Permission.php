<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission, $guard = null)
    {
        if (Auth::user()->hasRole('Super Admin')){
            return $next($request);
        }
        if (app('auth')->guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            if (Auth::user()->business_id > 0){
                $permissions = Auth::user()->getAllPermissions()->pluck('name','name')->toArray();
                if (\Arr::exists($permissions,$permission)){
                    return $next($request);
                }
            }else{
                $permissions = Auth::user()->getAllPermissions()->pluck('name','name')->toArray();
                if (\Arr::exists($permissions,$permission)){
                    return $next($request);
                }
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
