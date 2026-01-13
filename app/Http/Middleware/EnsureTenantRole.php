<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // ← AGREGAR ESTO
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {  // ← Auth::check() en lugar de auth()->check()
            abort(401);
        }

        if (! Auth::user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized for this restaurant');
        }

        return $next($request);
    }
}
