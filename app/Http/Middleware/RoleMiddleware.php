<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $severalRole = explode("|", $role);

        if (!in_array($request->user()->role, $severalRole)) {
            return response()->json([
                'status' => 403,
                'message' => 'You dont have permission!'
            ], 403);
        }
        return $next($request);
    }
}
