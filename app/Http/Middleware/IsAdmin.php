<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isAdmin = $request->user()->is_admin;
        if (!$isAdmin) {
            return response()->json([
                'message' => 'User is not an admin'
            ], 401);
        }

        return $next($request);
    }
}
