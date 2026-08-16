<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        // Verificar si el usuario tiene uno de los roles permitidos
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
