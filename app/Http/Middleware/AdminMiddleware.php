<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next): Response
        {
            $user = Auth::user()->load('role');

            if ($user->role->id == 1) {
                return $next($request);
            }

            return response()->json(['error' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }
}
