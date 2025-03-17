<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Redirection vers la page de login pour les routes web
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Vérification du rôle
        if (!$request->user()->hasRole($role)) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Accès interdit'], 403);
            }
            return redirect()->route('home')->with('error', 'Accès non autorisé');
        }

        return $next($request);
    }
}
