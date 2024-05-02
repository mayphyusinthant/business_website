<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        {
            // Check if the user has the "admin" role
            if (auth()->user() && auth()->user()->role == 'admin') {
                return $next($request);
            }
    
            // If not, redirect or return an unauthorized response
            abort(403, 'Unauthorized action.');
        }
    }
}
