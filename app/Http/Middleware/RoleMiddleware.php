<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek User Login (Support Web Session & API Token)
        $user = null;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } elseif (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }

        // Jika tidak ada user yang login
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // 2. Cek Role
        if ($user->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden: Access denied.'], 403);
            }
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
