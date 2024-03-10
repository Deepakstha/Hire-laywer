<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckLawyerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            // Assuming the user model has a role attribute or method that returns the role
            if (Auth::user()->role == 'lawyer') {
                return $next($request);
            } else {
                return redirect('/login')->with('error', 'You do not have permission to access this page.');
            }
        }

        return redirect('/login');
        // return $next($request);
    }
}
