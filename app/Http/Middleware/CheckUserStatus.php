<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status !== 'active') {
            
            if ($request->routeIs('waiting.approval') || $request->routeIs('logout')) {
                return $next($request);
            }
            
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Tu cuenta está pendiente de aprobación.'], 403);
            }
            
            return redirect()->route('waiting.approval');
        }

        return $next($request);
    }
}
