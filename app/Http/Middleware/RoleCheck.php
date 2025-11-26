<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // If user not logged in
        if (!$user) {
            return response([
                "status" => 401,
                "message" => "You must be logged in."
            ], 401);
        }

        // Check if user has any of the allowed roles
        if (!$user->hasAnyRole($roles)) {
            return response([
                "status" => 403,
                "message" => "Access denied. Missing required role(s)."
            ], 403);
        }

        return $next($request);
    }
}
