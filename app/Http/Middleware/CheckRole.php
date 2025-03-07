<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (auth()->check() && auth()->user()->level === $role) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Akses ditolak. Anda tidak memiliki izin yang diperlukan.');
    }
} 