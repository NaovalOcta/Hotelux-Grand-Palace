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
        // Cek apakah user login menggunakan guard API
        if (!Auth::guard('api')->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = Auth::guard('api')->user();

        // Cek Role
        if ($user->role !== $role) {
            return response()->json(['message' => 'Forbidden: You do not have access.'], 403);
        }

        return $next($request);
    }
}
