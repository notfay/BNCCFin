<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }
        
        if (Auth::user()->role !== $role) {
            if (Auth::user()->role === 'user' && $role === 'admin') {
                return redirect()->route('user.products.index')
                    ->with('error', 'You do not have permission to access this page.');
            }
            
            if (Auth::user()->role === 'admin' && $role === 'user') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'This area is for regular users only.');
            }
            
            return redirect()->route('login');
        }

        return $next($request);
    }
}