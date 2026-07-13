<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $required = collect(func_get_args())->skip(2)->flatMap(function ($arg) {
            return explode('|', (string) $arg);
        })->filter()->values();

        if ($required->isEmpty()) {
            return $next($request);
        }

        if (! $user) {
            abort(401);
        }

        $has = $required->contains(fn ($permission) => $user->hasPermission($permission));

        if (! $has) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
