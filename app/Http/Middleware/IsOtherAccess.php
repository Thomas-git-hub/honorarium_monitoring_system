<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOtherAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->usertype->name === 'Budget Office' )  {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->usertype->name === 'Dean' )  {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->usertype->name === 'Accounting' )  {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->usertype->name === 'Cashiers' )  {
            return $next($request);
        }


        // Redirect to home or any other page
        return redirect('/admin_dashboard')->with('error', 'You do not have superadmin access.');
        return $next($request);
    }
}
