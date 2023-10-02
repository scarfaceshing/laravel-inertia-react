<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidPermission;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class BackendRequestAllowOnlyPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = $request->user();
        
        if (!$request->user()) {
            throw new AuthenticationException;
        }

        collect($permissions)->each( function (string $permission = '') use ($user) {
            if (!$user->hasPermissionTo($permission)) {
                throw new InvalidPermission;
            }
        });
        
        return $next($request);
    }
}
