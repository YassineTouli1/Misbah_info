<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        Log::info('CheckRole middleware', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->role,
            'required_role' => $role,
            'is_authenticated' => Auth::check(),
            'session_id' => $request->session()->getId()
        ]);

        if (!Auth::check()) {
            Log::warning('User not authenticated');
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        if (Auth::user()->role !== $role) {
            Log::warning('Access denied - wrong role', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role,
                'required_role' => $role
            ]);
            abort(403, 'Accès non autorisé.');
        }

        Log::info('Access granted', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role,
            'required_role' => $role
        ]);

        return $next($request);
    }
}
